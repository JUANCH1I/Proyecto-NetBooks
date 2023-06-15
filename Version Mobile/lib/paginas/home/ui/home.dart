import 'dart:async';
import 'dart:convert';

import 'package:Presma/paginas/qr/modelo/prestamoData.dart';
import 'package:Presma/paginas/qr/controlador/qrControlador.dart';
import 'package:flutter/material.dart';
import 'package:Presma/paginas/qr/ui/qrscan.dart';
class Home extends StatefulWidget {
  
  Home({super.key});
  
  
  @override
  HomeState createState() => HomeState();
  
}
  
   

class HomeState extends State<Home>{

  List<PrestamoData> listaPrestamo = [];
  StreamController _streamController = StreamController();
  int devolverPedir = 0;

  Future getDatosQR() async{
    listaPrestamo = await QrControlador().getDatosPrestamo();
    _streamController.sink.add(listaPrestamo);
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
        appBar: AppBar(
          
        ),
        body: SafeArea(
        child: Column(
          children: [
            Flexible(child: 
              StreamBuilder(
          stream: _streamController.stream,
          builder: (context, snapshots){
            
            if(snapshots.hasData){
              return ListView.builder(
                itemCount: listaPrestamo.length,
                itemBuilder: ((context, index) {
                
                PrestamoData prestamoData = listaPrestamo[index];
                return ListBody(
                  children: [
                    Text('Código del material: ${prestamoData.idrecurso}' ?? 'No se pidió ningún material todavía'),
                    Text('Inicio del prestamo: ${prestamoData.inicio_prestamo}' ??'No se pidió ningún material todavía'),
                    Text('Fin del prestamo: ${prestamoData.fin_prestamo}' ?? 'No se pidió ningún material todavía'),
                  ],
                  
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
                setState(() {
                  devolverPedir = 0;
                });
                
                Navigator.push(context, MaterialPageRoute(builder: (context) => QrScan(),));
              }, 
              
              child: Text('Pedir Material')),

        ElevatedButton(
              onPressed: () {
                setState(() {
                  devolverPedir = 1;
                });
                
                Navigator.push(context, MaterialPageRoute(builder: (context) => QrScan(),));
              }, 
              
              child: Text('Devolver Material'))
          ],
        ) 
       
      ),
      
    );
  }

  
  }
                
            
