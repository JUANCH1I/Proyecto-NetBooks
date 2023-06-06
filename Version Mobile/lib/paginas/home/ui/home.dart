import 'package:flutter/material.dart';
import 'package:Presma/paginas/qr/ui/qrscan.dart';

class Home extends StatelessWidget{
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: ListView(
        children: [
          Center(
            child: ElevatedButton(
              onPressed: () {
                Navigator.push(context, MaterialPageRoute(builder: (context) => QrScan(),));
              }, 
              child: Text('Escanear QR')),
          )
        ],
      ),
    );
  }

}