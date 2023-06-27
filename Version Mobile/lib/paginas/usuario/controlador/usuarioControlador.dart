import 'dart:convert';

import 'package:Presma/paginas/usuario/modelo/usuarioModelo.dart';
import 'package:http/http.dart' as http;

List<Usuario> usuarioFromJson(String jsonstring){
  final data = json.decode(jsonstring);
  return List<Usuario>.from(
    data.map((item) => Usuario.fromJson(item))
  );
}
Future<List<Usuario>> getDatosUsuario() async {
    final response = await http.get(Uri.parse("https://gestion.tecnica29de6.edu.ar/presma/getusuariodata.php"));
    if (response.statusCode == 200){
      List<Usuario> datosUsuario = usuarioFromJson(response.body);
      return datosUsuario;
    }
    else{
      return <Usuario>[];
    }
  }