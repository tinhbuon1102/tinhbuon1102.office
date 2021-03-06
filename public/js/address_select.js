var selectedArray = [];
// 引数のエリアコードの子地域情報を取ってくる
function fetchChildrenArea(ac, success, error){

    // apiの設定情報
    // http://developer.yahoo.co.jp/webapi/map/openlocalplatform/v1/addressdirectory.html
    var api = {
        url: "http://search.olp.yahooapis.jp/OpenLocalPlatform/V1/addressDirectory",
        appid: "dj0zaiZpPWpvUXpPQzh4UFpXTSZzPWNvbnN1bWVyc2VjcmV0Jng9OWU-"
    };

    var that = this;

    // キャッシュあればキャッシュを使用
    that.cache = that.cache || {};
    if( that.cache[ac] ){
        success && success(that.cache[ac]);
        return;
    }


    var data, props, i, ii;

    if(yahooAddress.error){
        error && error();
        return;
    }

    // jsonデータから子地域データを取得
    data = yahooAddress;
    props = ["Feature", "0", "Property", "AddressDirectory"];
    while(data && props.length){
        data = data[props.shift()];
    }
    if(!data || !data.length){
        error && error();
        return;
    }

    i = 0, ii = data.length;
    while(i < ii){
        data[i] = {
            ac: data[i]["AreaCode"],
            name: data[i]["Name"]
        };
        i++;
    }

    that.cache[ac] = data;
    success && success(data);

}


var $selects = jQuery(".address_select");

var setSelectOptions = function($select, data){
    var i, ii, options = [];
    var currentVal = $select.val();

    //options.push("<option value=''>" + $select.attr("data-label") + "</option>");
    if(data){
        for(i = 0, ii = data.length; i < ii; i++){
            options.push("<option data-ac='" + data[i].ac + "' "+ (currentVal == data[i].name ? 'selected' : '') +" value='" + data[i].name + "'>" + data[i].name + "</option>");
        }
    }
    if(selectedArray.length!=0)
    {
        jQuery.each(selectedArray, function(index, value){
            options.push("<option data-ac='" + value + "' "+ (currentVal == value ? 'selected' : '') +" value='" + value + "' selected >" + value + "</option>");
        });

        // The source of the tags for autocompletion
        /*var tagsource = [
        'php', 'jquery', 'python', 'cobol'
        ]*/
        // Turn the input into the tagging input
    }
    //jQuery('#ms').tagging(selectedArray);
    options.length === 1? $select.show() : $select.show();
    $select.html(options.join(""));


    jQuery(".chosen-select").chosen("destroy");
    jQuery(".chosen-select").chosen();
    /*jQuery('#ms').multipleSelect({
            width: '100%',
            display: 'none'
    });*/
    
    $select.trigger('change');


};

$selects.eq(0).change(function(){
    var ac = jQuery(this).find(":selected").attr("data-ac");
    if(ac){
        fetchChildrenArea(ac, function(data){
            setSelectOptions($selects.eq(1), data);
        });
    }else{
        setSelectOptions($selects.eq(1));
    }
    setSelectOptions($selects.eq(2));
});

$selects.eq(1).change(function(){
    var ac = jQuery(this).find(":selected").attr("data-ac");
    if(ac){
        fetchChildrenArea(ac, function(data){
            setSelectOptions($selects.eq(2), data);
        });
    }else{
        setSelectOptions($selects.eq(2));
    }
});

fetchChildrenArea("JP", function(data){
    setSelectOptions($selects.eq(0), data);
    setSelectOptions($selects.eq(1));
    setSelectOptions($selects.eq(2));
    //jQuery(".chosen-select").chosen("destroy");
    //jQuery(".chosen-select").chosen();
});
