import 'package:Presma/paginas/login/modelo/loginModelo.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
class loginControlador{


 List<loginRespuestaModelo> loginRespuestaFromJson(String jsonstring){
  final data = jsonDecode(jsonstring);
  return List<loginRespuestaModelo>.from(
    data.map((item) => loginRespuestaModelo.fromJson(item))
  );
}

  Future<List<loginRespuestaModelo>> loginRespuesta(loginRequestModelo request)async{
    
    final response = await http.post(Uri.parse('http://192.168.0.71/Presma/login.php'),
    body: request.toJson());
    if (response.statusCode == 200){
      
  
    List<loginRespuestaModelo> respuesta = loginRespuestaFromJson(response.body);
    return respuesta;
    }
    else{
      return <loginRespuestaModelo>[];
    }
  }
}