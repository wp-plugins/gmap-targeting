function gmt_overwrite_shortcode(){
    jQuery("#gmt_map_canvas").css("width", jQuery("[name=gmt_map_width]").val()+"px");
    jQuery("#gmt_map_canvas").css("height", jQuery("[name=gmt_map_height]").val()+"px");
    gmt_initMap(jQuery("[name=gmt_latitude]").val(), jQuery("[name=gmt_longitude]").val(),jQuery("[name=gmt_map_type]").val(),parseInt(jQuery("[name=gmt_map_zoom]").val(),10));
}

function gmt_set_coordinates(coordinates){
    coordinates=coordinates.replace("(", "");
    coordinates=coordinates.replace(")", "");
    coordinates=coordinates.split(',');
    jQuery("[name=gmt_latitude]").val(coordinates[0].replace(" ", ""));
    jQuery("[name=gmt_longitude]").val(coordinates[1].replace(" ", ""));
    jQuery("#gmt_latitude").html(jQuery("[name=gmt_latitude]").val());
    jQuery("#gmt_longitude").html(jQuery("[name=gmt_longitude]").val());
}

function gmt_set_zoom(zoom){
    jQuery("[name=gmt_map_zoom]").val(zoom);
    jQuery("#gmt_zoom").html(zoom);
}

function gmt_tooltip_change(value){
    value=value.replace(/\r\n|\r|\n/g,'<br />');
    jQuery("#gmt_tooltip").html(value);
}

function gmt_move_map(){
    var position=jQuery("[name=gmt_map_position]").val();
    jQuery("#gmt_map_canvas").css("float",position);
    jQuery("#gmt_map_canvas").removeClass();
    jQuery("#gmt_map_canvas").addClass("gmt_"+position+"_map_position");

}

