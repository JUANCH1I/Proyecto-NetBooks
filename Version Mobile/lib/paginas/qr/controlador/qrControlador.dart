import 'dart:convert';
import 'package:Presma/paginas/qr/modelo/prestamoData.dart';
import 'package:Presma/paginas/qr/modelo/qrdata.dart';
import 'package:Presma/paginas/usuario/modelo/usuarioModelo.dart';
import 'package:http/http.dart' as http;

class QrControlador {
  List<PrestamoData> PrestamoDataFromJson(String jsonstring){

  final data = jsonDecode(jsonstring);
  
    return List<PrestamoData>.from(
    data.map((item) => PrestamoData.fromJson(item))
    );
}
Future<List<PrestamoData>> getDatosPrestamo(Usuario usuario) async {
    final response = await http.post(Uri.parse("https://gestion.tecnica29de6.edu.ar/presma/getdata.php"), body: usuario.toJson());
    if (response.statusCode == 200){
      List<PrestamoData> datosPrestamo = PrestamoDataFromJson(response.body);
      return datosPrestamo;
    }
    else{
      return List<PrestamoData>.empty();
    }
  }

  Future<String> pedirMaterial(QrData datosqr)async{
    
    final response = await http.post(Uri.parse('https://gestion.tecnica29de6.edu.ar/presma/pedirmaterial.php'),
    body: datosqr.toJson());
    return jsonDecode(response.body);
  }

  Future<String> devolverMaterial(QrData datosqr)async{
    
    final response = await http.post(Uri.parse('https://gestion.tecnica29de6.edu.ar/presma/devolvermaterial.php'),
    body: datosqr.toJson());
    return jsonDecode(response.body);
  }
}


