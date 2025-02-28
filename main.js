$.get("region.php", function (data) {
    option = "<option>Select a region</option>";
    result = JSON.parse(data);
    for (let index = 0; index < result.length; index++) {
        const element = result[index];
        option += "<option value = '"+result[index]['regDesc']+"'>"+result[index]['regDesc']+"</option>";
    }
    $("#region").html(option);
});
$("#region").change(function(){
    $.post("province.php", {
        region: $(this).val()
    }, function(data){
        result = JSON.parse(data);
        option = "<option> Select a province </option>";
        for(let i = 0; i<result.length; i++){
            option += "<option value = '"+result[i]["provDesc"]+"'>"+result[i]["provDesc"]+"</option>";
        }
        $("#province").html(option)
    });
});

$("#province").change(function(){
    $.post("municipality.php", {
        province: $(this).val()
    }, function(data){
        console.log(data);
        result = JSON.parse(data);
        option = "<option>Select a city</option>";
        for(let i = 0; i<result.length; i++){
            option += "<option values='"+result[i]["citymunDesc"]+"'>"+result[i]["citymunDesc"]+"</option>";
        }
        $("#municipality").html(option);
    });
});

$("#municipality").change(function(){
    $.post("brgy.php", {
        municipality: $(this).val()
    }, function(data){
        console.log(data);
        result = JSON.parse(data);
        option = "<option>Select a barangay</option>";
        for(let i = 0; i<result.length; i++){
            option += "<option values='"+result[i]["brgyDesc"]+"'>"+result[i]["brgyDesc"]+"</option>";
        }
        $("#barangay").html(option);
    });
});
$("#register").click(function () {
    if($("#region").val() == "Select a region"){
        alert("empty");
    }
    if($("#municipality").val() == null || $("#city").val() == "Select a municipality" ){
        alert("empty");
    }

});
$("#burger").click(function () {
    $("#sidenav").css({"width": "45%"});
})
$("#close").click(function () {
    $("#sidenav").css({"width": "0"});
})