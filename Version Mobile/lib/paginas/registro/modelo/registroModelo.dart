class registroRequestModelo{
  String? user_name;
  String? user_email;
  String? user_password;
  String? mensaje;
  registroRequestModelo({this.user_name,
                    this.user_password, this.user_email, this.mensaje});

  Map<String,dynamic> toJson(){
    return{
    'user_name': user_name,
    'user_password': user_password,
    'user_email': user_email};
  }
 
 factory registroRequestModelo.fromJson(Map<String,dynamic> json){
  return registroRequestModelo(
    mensaje: json['message'],
  );
 }
}
