import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:Presma/paginas/qr/qrdata.dart';
import 'package:mobile_scanner/mobile_scanner.dart';
class QrControlador {
  List<QrData> qrDataFromJson(String jsonstring){
  final data = json.decode(jsonstring);
  return List<QrData>.from(
    data.map((item) => QrData.fromJson(item))
  );
}
Future<List<QrData>> getDatosQr() async {
    final response = await http.get(Uri.parse("http://192.168.0.71/Presma/getdata.php"));
    if (response.statusCode == 200){
      List<QrData> datosqr = qrDataFromJson(response.body);
      return datosqr;
    }
    else{
      return <QrData>[];
    }
  }

  Future<String> insertarDatosPrestamo(QrData datosqr)async{
    
    final response = await http.post(Uri.parse('http://192.168.0.71/Presma/adddata.php'),
    body: datosqr.toJson());
    if (response.statusCode == 200){
      return response.body;
    }
    else{
      return "error";
    }
  }
}
