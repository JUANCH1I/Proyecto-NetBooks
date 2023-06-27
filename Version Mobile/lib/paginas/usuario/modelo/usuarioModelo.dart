import 'package:Presma/main.dart';

class Usuario{
  String? idusuario;
  String? user_name;
  String? user_email;
  int? idRol;

  Usuario({required this.idusuario,
           this.user_name,
           this.user_email,
           this.idRol});

  factory Usuario.fromJson(Map<String, dynamic> json){
    return Usuario(
      idusuario: json['idusuario'],
      user_name: json['user_name'],
      user_email: json['user_email'],
      idRol: json['idRol']);
  } 

  Map<String,dynamic> toJson(){
    return{
    'idusuario': idusuario,};
  }
 
}