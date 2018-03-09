// google login
var provider = new firebase.auth.GoogleAuthProvider();
var user;

// Get a reference to the database service
var database = firebase.database();



//googleボタンで発動する関数
function onSignIn(googleUser) {
firebase.auth().signInWithPopup(provider).then(function(result) {
    
   var profile = googleUser.getBasicProfile();
 console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
 console.log('Name: ' + profile.getName());
 console.log('Image URL: ' + profile.getImageUrl());
 console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.

    //googleアカウント情報を変数に
    var userID = profile.getId();
    var userName = profile.getName();
    var userEmail = profile.getEmail();
    var imageUrl = profile.getImageUrl();


  // The ID token you need to pass to your backend:
    var id_token = googleUser.getAuthResponse().id_token;
    console.log("ID Token: " + id_token);
    //You have your data in the variable `id_token`. Now send this to your server to be stored 
        
  // This gives you a Google Access Token. You can use it to access the Google API.
  var token = result.credential.accessToken;
  // The signed-in user info.
  user = result.user;
        
    //firebaseのDBに書き込み
writeUserData(userID, userName, userEmail, imageUrl);
 
    //mysqlのDBに登録
sendDb(userID, userName, userEmail, imageUrl);
    

}).catch(function(error) {
  // Handle Errors here.
  var errorCode = error.code;
  var errorMessage = error.message;
  // The email of the user's account used.
  var email = error.email;
  // The firebase.auth.AuthCredential type that was used.
  var credential = error.credential;
  // ...
});   
}


function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log('User signed out.');
    });
  }

//firebaseのDBに書き込む関数
function writeUserData(userID, userName, userEmail, imageUrl) {
  firebase.database().ref('users/' + userID).set({
    name: userName,
    email: userEmail
  });
    console.log('DB登録できた');
}

//ajaxでmysqlのDBに登録する関数
function sendDb(userID, userName, userEmail, imageUrl){
 $(function () {
     //ajaxのGET送信metodでmysql用のphpへ飛ばす
         $.get("dbsave.php", {
                 userName: userName,
                 userEmail: userEmail,
                 userID: userID
             },
             function () {
              console.log('dbsave移動');
             window.open('json_map.php', '_self');
             //window.open('dbsave.php', '_self');
             }
              );
 });
}