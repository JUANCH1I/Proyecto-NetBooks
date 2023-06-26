import 'package:Presma/paginas/Registro/modelo/RegistroModelo.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
class RegistroControlador{

Future<String> registro(registroRequestModelo request) async {
    final response = await http.post(Uri.parse("http://192.168.0.71/Presma/registro.php"), body: request.toJson());
    if (response.statusCode == 200){
      String respuesta = json.decode(response.body);
      return respuesta;
    }
    else{
      throw Exception("Error");
    }
  }

 
}