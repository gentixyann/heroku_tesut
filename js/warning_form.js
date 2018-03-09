
$(function(){
$('.delete').click(function(){
  
  if(!confirm('まじで消すの？？')){
    return false;
  }else{
    location.href = 'profile.php';
  }
});
});






$(function(){

// $("form").submit(function(){
//$('#update').on('submit',function(e){
$('#update').on('click',function(e){

var err = 0;

if($("input[name='nick_name']").val()==""){
if($("span#nick_name").css("color") != "red"){
$("input[name='nick_name']").css("border","1px solid red").after("<span id='nick_name'>あんた名乗って無いよね？</span>");
$("span#nick_name").css("color","red");
}
err = 1;
}else{
$("input[name='nick_name']").css("border","1px solid gray");
$("span#nick_name").text("");
$("span#nick_name").css("color","gray");
}



if($("input[name='email']").val()==""){
if($("span#email").css("color") != "red"){
$("input[name='email']").css("border","1px solid red").after("<span id='email'>メールアドレスを入力してください</span>");
$("span#email").css("color","red");
}
err = 1;
}else{
$("input[name='email']").css("border","1px solid gray");
$("span#email").text("");
$("span#email").css("color","gray");
}


if(err==1){
return false;

}

}); // end of submit

});