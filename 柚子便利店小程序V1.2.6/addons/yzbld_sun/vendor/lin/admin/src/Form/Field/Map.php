<?php

namespace Encore\Admin\Form\Field;

use Encore\Admin\Admin;
use Encore\Admin\Form\Field;

class Map extends Field
{
    /**
     * Column name.
     *
     * @var array
     */
    protected $column = [];

    protected  $map_key = "";


    protected static $js = [
        //'//map.qq.com/api/js?v=2.exp',
    ];


    public function __construct($column, $arguments)
    {
        $this->column['lat'] = $column;
        $this->column['lng'] = $arguments[0];
        if(count($arguments) > 2)
            $this->map_key = $arguments[2];

        array_shift($arguments);

        $this->label = $this->formatLabel($arguments);
        $this->id = $this->formatId($this->column);
        //dd($this->id);

        $js = '//map.qq.com/api/js?v=2.exp&key='.$this->map_key;
        Admin::js($js);
        $this->useTencentMap();
    }


    public function useTencentMap()
    {
        $this->script = <<<EOT
        var g_map = null;
        var g_marker = null;
        function initTencentMap(name) {
            var lat = $('#{$this->id['lat']}');
            var lng = $('#{$this->id['lng']}');

            var center = new qq.maps.LatLng(lat.val(), lng.val());

            var container = document.getElementById("map_"+name);
            g_map = new qq.maps.Map(container, {
                center: center,
                zoom: 13
            });

            g_marker = new qq.maps.Marker({
                position: center,
                draggable: true,
                map: g_map
            });

            if( ! lat.val() || ! lng.val()) {
                var citylocation = new qq.maps.CityService({
                    complete : function(result){
                        g_map.setCenter(result.detail.latLng);
                        g_marker.setPosition(result.detail.latLng);
                    }
                });

                citylocation.searchLocalCity();
            }

            qq.maps.event.addListener(g_map, 'click', function(event) {
                g_marker.setPosition(event.latLng);
            });

            qq.maps.event.addListener(g_marker, 'position_changed', function(event) {
                var position = g_marker.getPosition();
                lat.val(position.getLat());
                lng.val(position.getLng());
            });
        }

        initTencentMap('{$this->id['lat']}{$this->id['lng']}');
EOT;


    }

    public function map_key($key)
    {
        $this->map_key = $key;
    }
    public function render()
    {

        $data = [
            "old"=>[
                "lng"=>old($this->column['lng'], $this->value['lng']),
                "lat"=>old($this->column['lat'], $this->value['lat'])
            ]
        ];
        $this->addExtraData($data);

        return parent::render();
    }
}
