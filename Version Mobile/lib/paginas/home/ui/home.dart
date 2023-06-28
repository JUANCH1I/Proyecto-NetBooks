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
          toolbarHeight: 40,
          title: Text("Presma", style: TextStyle(fontSize: 25),),
          backgroundColor: Color.fromARGB(255, 223, 236, 243)
        ),
        body: SafeArea(
        child: Column(
          children: [
            SizedBox(height: 20,),
            Flexible(
              fit: FlexFit.tight,
              flex: 0,
              child: 
              StreamBuilder(
          stream: _streamController.stream,
          builder: (context, snapshots){
          
              return ListView.builder(
                shrinkWrap: true,
                itemCount: listaPrestamo.length,
                itemBuilder: ((context, index) {
                PrestamoData prestamoData = listaPrestamo[index];
                if(snapshots.hasData){
                  if(listaPrestamo.isNotEmpty){
                    return Column(
                      children: [
                        Container(
                      decoration: BoxDecoration(
                        color: Colors.white70,
                        border: Border.all(color: Colors.black54), 
                        boxShadow:[BoxShadow(
                          color: Color.fromARGB(47, 0, 0, 0),
                          offset: const Offset(
                                                5.0,
                                                5.0,
                                                ),
                          blurRadius: 10.0,
                          spreadRadius: 2.0,
                        )]),
                      child: ListBody(
                                      children: [
                      Padding(
                        padding: const EdgeInsets.all(5.0),
                        child: Text('Código del material: ${prestamoData.recurso_id}', style: TextStyle(fontSize: 17)),
                      ),
                      Padding(
                        padding: const EdgeInsets.all(5.0),
                        child: Text('Inicio del prestamo: ${prestamoData.inicio_prestamo}', style: TextStyle(fontSize: 17)),
                      ),
                      Padding(
                        padding: const EdgeInsets.all(5.0),
                        child: Text('Fin del prestamo: ${prestamoData.fin_prestamo}', style: TextStyle(fontSize: 17)),
                      ),
                      
                                      ],
                                      
                                    ),
                    ),
                    SizedBox(height: 15,),
                      ],
                    );
                     
                  }
                  else{
                  return Text("Todavía no se pidió ningún material", style: TextStyle(fontSize: 25),);
                }

                }
                else{
                  CircularProgressIndicator();
                }
                
                
              }));
            
          }

        ),
            ),
            SizedBox(height: 30,),
            Center(
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  ElevatedButton( 
                                  onPressed: () {
                                    Navigator.push(context, MaterialPageRoute(builder: (context) => QrScan(devolverPedir: 0),));
                                    }, 
                                  child: Padding(
                                    padding: const EdgeInsets.all(8.5),
                                    child: Text('Pedir Material', style: (TextStyle(fontSize: 21)),),
                                  )),
                                  SizedBox(height: 10,),
                  ElevatedButton(
                                  onPressed: () {
                                    Navigator.push(context, MaterialPageRoute(builder: (context) => QrScan(devolverPedir: 1),));
                                    }, 
                                  child: Padding(
                                    padding: const EdgeInsets.all(8.5),
                                    child: Text('Devolver Material', style: (TextStyle(fontSize: 21)),),
                                  ))
                ],
              ),
            ),
        
          ],
        ) 
       
      ),
      
    );
  }

  
  }
                
            
