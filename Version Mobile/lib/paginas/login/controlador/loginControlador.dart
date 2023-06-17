import 'package:Presma/paginas/login/modelo/loginModelo.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
class loginControlador{

Future<String> login(loginRequestModelo request) async {
    final response = await http.post(Uri.parse("http://192.168.0.71/Presma/login.php"), body: request.toJson());
    if (response.statusCode == 200){
      String respuesta = json.decode(json.encode(response.body));
      return respuesta;
    }
    else{
      throw Exception("Error");
    }
  }

  /* Future<loginRespuestaModelo> login(loginRequestModelo request)async{
    
    final response = await http.post(Uri.parse('http://192.168.0.71/Presma/login.php'),
    body: request.toJson());
    if (response.statusCode == 200){
      
    final respuesta = loginRespuestaModelo.fromJson(json.decode(json.encode(response.body)));
    return respuesta;


    }
    else{
      throw Exception('Error');
    }
  }*/
}