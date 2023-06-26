import 'dart:async';


import 'package:Presma/main.dart';
import 'package:Presma/paginas/qr/modelo/prestamoData.dart';
import 'package:Presma/paginas/qr/controlador/qrControlador.dart';
import 'package:Presma/paginas/usuario/modelo/usuarioModelo.dart';
import 'package:flutter/material.dart';
import 'package:Presma/paginas/qr/ui/qrscan.dart';

class Home extends StatefulWidget {
  
  Home({super.key});
  
  
  @override
  HomeState createState() => HomeState();
  
}


class HomeState extends State<Home>{
  refreshState(){
    initState();
  }
  late int devolverPedir;
  List<PrestamoData> listaPrestamo = [];
  StreamController _streamController = StreamController();
  Usuario user = Usuario(idusuario: MyAppState().idusuario);

  Future getDatosQR() async{
    listaPrestamo = await QrControlador().getDatosPrestamo(user);
    _streamController.sink.add(listaPrestamo);
  }
 
 

  @override

 void initState() {
    getDatosQR();
    MyAppState().addListener(() => mounted ? setState(() {}) : null);
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
          
              return ListView.builder(
                itemCount: listaPrestamo.length,
                itemBuilder: ((context, index) {
                PrestamoData prestamoData = listaPrestamo[index];
                if(snapshots.hasData){
                  return ListBody(
                  children: [
                    Text('Código del material: ${prestamoData.recurso_id}'),
                    Text('Inicio del prestamo: ${prestamoData.inicio_prestamo}'),
                    Text('Fin del prestamo: ${prestamoData.fin_prestamo}'),
                  ],
                  
                );
                }
                else{
                  return ListTile(
                    title: Text("No se pidió ningún material todavía"),
                  );
                }
                
                
              }));
            
          }

        ),
            ),
        ElevatedButton(
              onPressed: () {
                
               
                Navigator.push(context, MaterialPageRoute(builder: (context) => QrScan(devolverPedir: 0),));
                
              }, 
              
              child: Text('Pedir Material')),

        ElevatedButton(
              onPressed: () {
                
                Navigator.push(context, MaterialPageRoute(builder: (context) => QrScan(devolverPedir: 1),));
                
              }, 
              
              child: Text('Devolver Material'))
          ],
        ) 
       
      ),
      
    );
  }

  
  }
                
            
