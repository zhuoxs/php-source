var Exhelper = {
    options: {}
};
Exhelper.init = function(o){
    this.options.baseurl = o.baseurl ;
}
Exhelper.getUrl = function(segs,params){
     
    var ops = segs.split('/');
    return this.options.baseurl  + "&method=" + ops[0] +"&op=" + ops[1] + "&" + params;
}
Exhelper.preview  =function(id){
    
    var url = this.getUrl('express/perview','id='+id);
    $('#modal-module-preview').modal().find('iframe').get(0).setAttribute('src', url);
      
    
}
 