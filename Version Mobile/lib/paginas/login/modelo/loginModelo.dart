class loginRequestModelo{
  String? user_email;
  String? user_password;

  loginRequestModelo({this.user_email,
                    this.user_password});

  Map<String,dynamic> toJson(){
    return{
    'user_email': user_email,
    'user_password': user_password};
  }
 
}

class loginRespuestaModelo{
  String user_login_status;
  String user_id;
  String? error;

  loginRespuestaModelo({required this.user_login_status, this.error, required this.user_id});

   factory loginRespuestaModelo.fromJson(Map<String, dynamic> json){
    return loginRespuestaModelo(
      user_login_status: json['user_login_status'],
      user_id: json['idusuario']);
  } 

}