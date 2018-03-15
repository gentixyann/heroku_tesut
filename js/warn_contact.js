$(function(){

$('#btn-submit').on('click',function(e){

var err = 0;

//name chack
if($("input[name='nick_name']").val()==""){
if($("span#nick_name").css("color") != "red"){
$("input[name='nick_name']").css("border","1px solid red").after("<span id='nick_name'>Hey! I want to know your name! Please tell me!</span>");
$("span#nick_name").css("color","red");
}
err = 1;
}else{
$("input[name='nick_name']").css("border","1px solid gray");
$("span#nick_name").text("");
$("span#nick_name").css("color","gray");
}


//email chack
if($("input[name='email']").val()==""){
if($("span#email").css("color") != "red"){
$("input[name='email']").css("border","1px solid red").after("<span id='email'>Did you forget something?</span>");
$("span#email").css("color","red");
}
err = 1;
}else{
$("input[name='email']").css("border","1px solid gray");
$("span#email").text("");
$("span#email").css("color","gray");
}

// contants chack
if($("textarea[name='inquiries']").val()==""){
if($("span#textarea").css("color") != "red"){
$("textarea[name='inquiries']").css("border","1px solid red").after("<span id='textarea'>Do you love me? Yes, I know.</span>");
$("span#textarea").css("color","red");
}
err = 1;
}else{
$("textarea[name='inquiries']").css("border","1px solid gray");
$("span#textarea").text("");
$("span#textarea").css("color","gray");
}

if(err==1){
return false;

}

}); // end of submit

});