import 'package:Presma/paginas/Registro/modelo/RegistroModelo.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
class RegistroControlador{

Future<String> registro(registroRequestModelo request) async {
    final response = await http.post(Uri.parse("https://gestion.tecnica29de6.edu.ar/presma/registro.php"), body: request.toJson());
    if (response.statusCode == 200){
      String respuesta = json.decode(response.body);
      return respuesta;
    }
    else{
      throw Exception("Error");
    }
  }

 
}