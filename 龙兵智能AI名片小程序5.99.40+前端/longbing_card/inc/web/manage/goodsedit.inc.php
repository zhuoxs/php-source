<?php
global $_GPC, $_W;

define( 'ROOT_PATH', IA_ROOT . '/addons/longbing_card/' );
is_file( ROOT_PATH . '/inc/we7.php' ) or exit( 'Access Denied Longbing' );
require_once ROOT_PATH . '/inc/we7.php';

$uniacid     = $_W[ 'uniacid' ];
$module_name = $_W[ 'current_module' ][ 'name' ];


$redis_sup_v3    = false;
$redis_server_v3 = false;


if ( $_GPC[ 'action' ] == 'edit' ) {
    $time = time();

    $data2 = $_GPC;
    $data  = [
        'name'          => $data2[ 'name' ],
        's_title'       => $data2[ 's_title' ],
        'type'          => $data2[ 'type' ],
        'cover'         => $data2[ 'cover' ],
        'image_url'     => $data2[ 'image_url' ],
        'price'         => $data2[ 'price' ],
        'freight'       => $data2[ 'freight' ],
        'view_count'    => $data2[ 'view_count' ],
        'sale_count'    => $data2[ 'sale_count' ],
        'stock'         => $data2[ 'stock' ],
        'unit'          => $data2[ 'unit' ],
        'extract'       => $data2[ 'extract' ],
        'is_self'       => $data2[ 'is_self' ],
        'top'           => $data2[ 'top' ],
        'recommend'     => $data2[ 'recommend' ],
        'switch'        => $data2[ 'switch' ],
        'staff_extract' => $data2[ 'staff_extract' ],
        'staff_switch'  => $data2[ 'staff_switch' ],
        'content'       => $data2[ 'content' ],
//        'vr_tittle'     => $data2[ 'vr_tittle' ],
//        'vr_cover'      => $data2[ 'vr_cover' ],
//        'vr_path'       => $data2[ 'vr_path' ],
//        'vr_switch'     => $data2[ 'vr_switch' ],
    ];
    if ( isset( $data2[ 'images' ] ) ) {
        $data[ 'images' ] = implode( ',', $data2[ 'images' ] );
    } else {
        $data[ 'images' ] = '';
    }
    $data[ 'images' ]      = trim( $data[ 'images' ], ',' );
    $data[ 'update_time' ] = $time;

    $type             = pdo_get( 'longbing_card_shop_type', [ 'id' => $data[ 'type' ] ] );
    $data[ 'type_p' ] = $type[ 'pid' ] ? $type[ 'pid' ] : $type[ 'id' ];

    $id     = $_GPC[ 'id' ];
    $result = false;

    //    echo '<pre>';
    //    var_dump( $data );
    //    die;
    if ( $id ) {//    修改商品
        $result = pdo_update( 'longbing_card_goods', $data, [ 'id' => $id ] );

        $destination_folder = ATTACHMENT_ROOT . '/images' . "/longbing_card/{$_W['uniacid']}";
        $image2             = $destination_folder . '/' . $_W[ 'uniacid' ] . '-goods-' . $id . '.png';

        @unlink( $image2 );
    } else {//  新增商品
        if ( LONGBING_AUTH_GOODS ) {
            $list  = pdo_getall( 'longbing_card_goods', [ 'uniacid'  => $_W[ 'uniacid' ],
                                                          'status >' => -1 ] );
            $count = count( $list );
            if ( $count >= LONGBING_AUTH_GOODS ) {
                message( "添加商品达到上限, 如需增加请购买高级版本", '', 'error' );
            }
        }


        $data[ 'create_time' ] = $time;
        $data[ 'uniacid' ]     = $_W[ 'uniacid' ];
        $result                = pdo_insert( 'longbing_card_goods', $data );

    }

    if ( $result && !$id ) {
        $goodsId = pdo_insertid();


        $id = $goodsId;
        pdo_insert( 'longbing_card_shop_spe', [ 'goods_id' => $goodsId, 'uniacid' => $_W[ 'uniacid' ], 'title' => '规格', 'create_time' => time(), 'update_time' => time() ] );
        $pid = pdo_insertid();
        pdo_insert( 'longbing_card_shop_spe', [ 'goods_id' => $goodsId, 'uniacid' => $_W[ 'uniacid' ], 'title' => $data2[ 'name' ], 'create_time' => time(), 'update_time' => time(), 'pid' => $pid ] );
        $spe_id = pdo_insertid();
        pdo_insert( 'longbing_card_shop_spe_price', [ 'goods_id' => $goodsId, 'uniacid' => $_W[ 'uniacid' ], 'spe_id_1' => $spe_id, 'create_time' => time(), 'update_time' => time(), 'price' => $data[ 'price' ], 'stock' => $data[ 'stock' ] ] );
    }

    if ( $result ) {


        if ( isset( $data2[ 'standard_id' ] ) && !empty( $data2[ 'standard_id' ] ) ) {
            foreach ( $data2[ 'standard_id' ] as $index => $item ) {
                if ( !$data2[ 'standard_title' ][ $index ] ) {
                    if ( $item == 0 ) {
                        continue;
                    }
                    pdo_update( 'longbing_card_shop_standard', [ 'status' => -1 ], [ 'goods_id' => $id, 'id' => $item ] );
                } else {
                    $price = $data2[ 'standard_price' ][ $index ];
                    $price = floatval( $price );
                    $price = $price ? $price : 0;
                    $price = sprintf( "%.2f", $price );

                    $stock = $data2[ 'standard_stock' ][ $index ];
                    $stock = intval( $stock );
                    $stock = $stock ? $stock : 0;

                    if ( $item == 0 ) {
                        $tmp = [
                            'goods_id'    => $id,
                            'title'       => $data2[ 'standard_title' ][ $index ],
                            'price'       => $price,
                            'stock'       => $stock,
                            'create_time' => $time,
                            'update_time' => $time,
                            'uniacid'     => $_W[ 'uniacid' ],
                        ];
                        pdo_insert( 'longbing_card_shop_standard', $tmp );
                    } else {
                        $tmp = [
                            'title'       => $data2[ 'standard_title' ][ $index ],
                            'price'       => $price,
                            'stock'       => $stock,
                            'update_time' => $time,
                        ];
                        pdo_update( 'longbing_card_shop_standard', $tmp, [ 'id' => $item ] );
                    }
                }
            }
        }


        message( $id, $this->createWebUrl( 'manage/goods' ), 'success' );
    }
    message( '操作失败', '', 'error' );
}

$where = [
    'uniacid' => $_W[ 'uniacid' ]
];

$id   = 0;
$info = [];
if ( isset( $_GPC[ 'id' ] ) ) {
    $where[ 'id' ] = $_GPC[ 'id' ];
    $id            = $_GPC[ 'id' ];
    $info          = pdo_get( 'longbing_card_goods', $where );
    if ( $info[ 'images' ] ) {
        $info[ 'images' ] = explode( ',', $info[ 'images' ] );
    }
}

$typeList = pdo_getall( 'longbing_card_shop_type', [ 'status' => 1, 'uniacid' => $_W[ 'uniacid' ] ] );


$typeList_tmp = array();
foreach ( $typeList as $k => $v ) {
    if ( $v[ 'pid' ] != 0 ) {
        $typeList[ $k ][ 'title' ] = '&nbsp;&nbsp;&nbsp;&nbsp;|----&nbsp;&nbsp;' . $v[ 'title' ];
    }
}
foreach ( $typeList as $k => $v ) {
    if ( $v[ 'pid' ] == 0 ) {
        array_push( $typeList_tmp, $v );
        foreach ( $typeList as $index => $item ) {
            if ( $item[ 'pid' ] != 0 && $v[ 'id' ] == $item[ 'pid' ] ) {
                array_push( $typeList_tmp, $item );
            }
        }
    }
}

$typeList = $typeList_tmp;


$standardList = false;

$standardList = pdo_getall( 'longbing_card_shop_standard', [ 'status' => 1, 'uniacid' => $_W[ 'uniacid' ] ] );


$companyList = pdo_getall( 'longbing_card_company', [
    'uniacid' => $uniacid,
    'status'  => 1,
    'pid' => 0
], [
                               'id',
                               'pid',
                               'name'
                           ]
);
$sonList = pdo_getall( 'longbing_card_company', [
    'uniacid' => $uniacid,
    'status'  => 1,
    'pid !=' => 0
], [
                           'id',
                           'pid',
                           'name'
                       ]
);

$companyListAll = lbSingleHandleCompanyOne($companyList, $sonList);


load()->func( 'tpl' );
include $this->template( 'manage/goodsEdit' );