import 'dart:async';


import 'package:Presma/main.dart';
import 'package:Presma/paginas/qr/modelo/prestamoData.dart';
import 'package:Presma/paginas/qr/controlador/qrControlador.dart';
import 'package:Presma/paginas/usuario/modelo/usuarioModelo.dart';
import 'package:flutter/material.dart';
import 'package:Presma/paginas/qr/ui/qrscan.dart';
import 'package:shared_preferences/shared_preferences.dart';

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
  

  Future getDatosQR() async{
    SharedPreferences prefs = await SharedPreferences.getInstance();
    Usuario user = Usuario(idusuario: prefs.getString('idusuario'));
    listaPrestamo = await QrControlador().getDatosPrestamo(user);
    _streamController.sink.add(listaPrestamo);
  }
 
 

  @override

 void initState() {
    MyAppState().addListener(() => mounted ? setState(() {}) : null);
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
          toolbarHeight: 30,
          title: Text("Presma"),
          backgroundColor: Color.fromARGB(255, 176, 191, 201)
        ),
        body: SafeArea(
        child: Column(
          children: [
            SizedBox(height: 20,),
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
                
            
