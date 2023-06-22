import 'dart:convert';
import 'dart:io';

//import 'package:Presma/paginas/Registro/controlador/RegistroControlador.dart';
//import 'package:Presma/paginas/Registro/modelo/RegistroModelo.dart';
import 'package:Presma/paginas/Registro/controlador/RegistroControlador.dart';
import 'package:Presma/paginas/Registro/modelo/RegistroModelo.dart';
import 'package:flutter/material.dart';
import 'package:Presma/paginas/home/ui/home.dart';
import 'package:http/http.dart' as http;


class Registro extends StatefulWidget {
  const Registro({super.key});

  @override
  State<Registro> createState() => RegistroState();
}

class RegistroState extends State<Registro>{
  GlobalKey<FormState> _globalKey = new GlobalKey();

  TextEditingController user= new TextEditingController();
  TextEditingController pass= new TextEditingController();
  registroRequestModelo requestModelo = new registroRequestModelo();
  bool esconderContrasena = true;
  bool llamadaAPI = false;

  @override

  void initState(){
    super.initState();
    requestModelo;
  }

    @override
   Widget build(BuildContext context) {

    return Scaffold(
      
      body: ListView(
        
        children: [
          Center(
            child: SafeArea(
              child: 
              Text('Registrarse', style: TextStyle(
                fontSize: 40,fontWeight: FontWeight.bold))
            )
          ),
          SizedBox(height: 50),
          Form(
            key: _globalKey,
            child: Column(
              children: <Widget>[
              Padding(
              padding: EdgeInsets.symmetric(horizontal: 50, vertical: 16),
              child: TextFormField(
                onSaved: (input) => requestModelo.user_name = input,
                keyboardType: TextInputType.text,
      
              decoration: InputDecoration(
                border: UnderlineInputBorder(),
                hintText: 'Usuario',
                icon: Icon(Icons.person))
              )
              ),
              SizedBox(height: 10),
              
              Padding(
              padding: EdgeInsets.symmetric(horizontal: 50, vertical: 16),
              child: TextFormField(
                onSaved: (input) => requestModelo.user_email = input,
                keyboardType: TextInputType.emailAddress,
              validator: (input) => (input!= null && !input.contains("@alu.tecnica29de6.edu.ar"))  || (input!= null && !input.contains("@tecnica29de6.edu.ar")) ? null : "Dominio incorrecto",
              decoration: InputDecoration(
                border: UnderlineInputBorder(),
                hintText: 'Mail',
                icon: Icon(Icons.email))
              )
              ),
              SizedBox(height: 10,),
              Padding(
              padding: EdgeInsets.symmetric(horizontal: 50, vertical: 16),
              child: TextFormField(
              onSaved: (input) => requestModelo.user_password = input,
              validator: (input) => input != null ? null:"Ingrese una contraseña",
              obscureText: esconderContrasena,
              decoration: InputDecoration(
                border: UnderlineInputBorder(),
                hintText: 'Contraseña',
                icon: Icon(Icons.lock),
                suffixIcon: IconButton(icon: esconderContrasena? Icon(Icons.visibility_off): Icon(Icons.visibility),
                                      onPressed: () {
                                        setState(() {
                                          esconderContrasena = !esconderContrasena;
                                        });
                                        
                                      },))
                )
              ),
              
              SizedBox(height: 15),
              ElevatedButton(
                onPressed: () async{
                  if(validar()){
                    RegistroControlador controlador = RegistroControlador();
                    String resultado = await controlador.registro(requestModelo);

                    SnackBar(content: Text(resultado),);
                    
                  }

                  
                  
                },
                                    
                child: const Text('Registrarse')),
          ],
          )
          ),
          
          SizedBox(height: 5),
          TextButton(
            onPressed: () {
              
            },
            child: Text('¿Olvidaste la contraseña?',style: TextStyle(decoration:TextDecoration.underline),),

          ),
          
          
         
          
        ],
        
      ),
    );
  }

  bool validar(){
    final form = _globalKey.currentState;
    if(form != null && form.validate()){
      form.save();
      return true;
    }
    return false;
  }
  }

