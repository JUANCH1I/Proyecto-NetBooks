import 'dart:async';
import 'dart:convert';

import 'package:Presma/paginas/qr/qrControlador.dart';
import 'package:Presma/paginas/qr/qrdata.dart';
import 'package:flutter/material.dart';
import 'package:Presma/paginas/qr/ui/qrscan.dart';
import 'package:mobile_scanner/mobile_scanner.dart';
import 'package:http/http.dart' as http;
class Home extends StatefulWidget {
  
  Home({super.key});
  
  
  @override
  HomeState createState() => HomeState();
  
}
  
   

class HomeState extends State<Home>{

  List<QrData> listaQr = [];
  StreamController _streamController = StreamController();
  insertarPrestamo(QrData datosqr) async{
  await QrControlador().insertarDatosPrestamo(datosqr).then((Success) => print(Success));
}

  Future getDatosQR() async{
    listaQr = await QrControlador().getDatosQr();
    _streamController.sink.add(listaQr);
  }
 
  @override

 void initState() {
    getDatosQR();
    super.initState();
    
}
@override



void descartar(){
  _streamController.close();
  super.dispose();
}


  
  @override
  Widget build(BuildContext context) {
    return Scaffold(
        
        body: SafeArea(
        child: Column(
          children: [
            Flexible(child: 
              StreamBuilder(
          stream: _streamController.stream,
          builder: (context, snapshots){
            
            if(snapshots.hasData){
              return ListView.builder(
                itemCount: listaQr.length,
                itemBuilder: ((context, index) {
                
                QrData qrdata = listaQr[index];
                return ListTile(
                  title: Text('Código del material: ${qrdata.idmaterial}'),
                  subtitle: Text('Fecha del préstamo: ${qrdata.periodo_de_prestamo}'),
                  
                );
                
              }));
            }
            return Center(
              child:
              CircularProgressIndicator()
            );
          }

        ),
            ),
        ElevatedButton(
              onPressed: () {
                Navigator.push(context, MaterialPageRoute(builder: (context) => QrScan(),));
                String qr = 'AAZ21969-07-20 20:18:04Z2023-06-07';
                QrData datosqrinsert = QrData(
                  idregistro: 2, 
                  periodo_de_prestamo: qr.substring(4,24) , 
                  fechas_extendidas: qr.substring(24), 
                  idmaterial: qr.substring(0,4));
                  insertarPrestamo(datosqrinsert);
              }, 
              
              child: Text('Escanear QR'))
          ],
        ) 
       
      ),
      
    );
  }

  
  }
                
            
