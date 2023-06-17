import 'dart:convert';
import 'package:Presma/paginas/qr/modelo/prestamoData.dart';
import 'package:Presma/paginas/qr/modelo/qrdata.dart';
import 'package:http/http.dart' as http;
import 'package:mobile_scanner/mobile_scanner.dart';

class QrControlador {
  List<PrestamoData> PrestamoDataFromJson(String jsonstring){
  final data = json.decode(jsonstring);
  return List<PrestamoData>.from(
    data.map((item) => PrestamoData.fromJson(item))
  );
}
Future<List<PrestamoData>> getDatosPrestamo() async {
    final response = await http.get(Uri.parse("http://192.168.0.71/Presma/getdata.php"));
    if (response.statusCode == 200){
      List<PrestamoData> datosPrestamo = PrestamoDataFromJson(response.body);
      return datosPrestamo;
    }
    else{
      return <PrestamoData>[];
    }
  }

  Future<String> pedirMaterial(QrData datosqr)async{
    
    final response = await http.post(Uri.parse('http://192.168.0.71/Presma/pedirmaterial.php'),
    body: datosqr.toJson());
    if (response.statusCode == 200){
      return response.body;
    }
    else{
      return "error";
    }
  }

  Future<String> devolverMaterial(QrData datosqr)async{
    
    final response = await http.post(Uri.parse('http://192.168.0.71/Presma/devolvermaterial.php'),
    body: datosqr.toJson());
    if (response.statusCode == 200){
      return response.body;
    }
    else{
      return "error";
    }
  }
}


