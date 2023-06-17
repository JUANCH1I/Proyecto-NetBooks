class loginRequestModelo{
  String? user_name;
  String? user_password;

  loginRequestModelo({this.user_name,
                    this.user_password});

  Map<String,dynamic> toJson(){
    return{
    'user_name': user_name,
    'user_password': user_password};
  }
 
}

class loginRespuestaModelo{
  String token;
  String? error;

  loginRespuestaModelo({required this.token, this.error});

   factory loginRespuestaModelo.fromJson(Map<String, dynamic> json){
    return loginRespuestaModelo(
      token: json['token'],);
  } 

}