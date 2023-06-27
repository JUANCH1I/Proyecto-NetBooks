
import 'dart:convert';
import 'dart:io';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:Presma/main.dart';
import 'package:Presma/paginas/login/controlador/loginControlador.dart';
import 'package:Presma/paginas/login/modelo/loginModelo.dart';
import 'package:Presma/paginas/registro/ui/registro.dart';
import 'package:flutter/material.dart';
import 'package:Presma/paginas/home/ui/home.dart';
import 'package:http/http.dart' as http;
import 'package:provider/provider.dart';


class Login extends StatefulWidget {
  const Login({super.key});

  @override
  State<Login> createState() => LoginState();
}

class LoginState extends State<Login>{
  GlobalKey<FormState> _globalKey = new GlobalKey();
  List<loginRespuestaModelo> listaRespuesta = [];
  TextEditingController user= new TextEditingController();
  TextEditingController pass= new TextEditingController();
  loginRequestModelo requestModelo = new loginRequestModelo();
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
              Text('Iniciar Sesión', style: TextStyle(
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
                onSaved: (input) => requestModelo.user_email = input,
                keyboardType: TextInputType.emailAddress,
              validator: (input) => ((input != null && !input.contains("@alu.tecnica29de6.edu.ar")) || (input!= null && !input.contains("@tecnica29de6.edu.ar"))) ? null : "Dominio incorrecto",
              decoration: InputDecoration(
                border: UnderlineInputBorder(),
                hintText: 'Mail',
                icon: Icon(Icons.person))
              )
              ),
              SizedBox(height: 10),
              Padding(
              padding: EdgeInsets.symmetric(horizontal: 50, vertical: 16),
              child: TextFormField(
              onSaved: (input) => requestModelo.user_password = input,
              validator: (input) => input == null ? "Ingrese una contraseña":null,
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
              SizedBox(height: 15,),
              ElevatedButton(
                onPressed: () async {
                  if(validar()){
                    loginControlador controlador = new loginControlador();
                    listaRespuesta = await controlador.loginRespuesta(requestModelo);
                    if(listaRespuesta[0].user_login_status == '1') {
                      SharedPreferences prefs = await SharedPreferences.getInstance();
                      prefs.setBool(logueado, true);
                      prefs.setString('idusuario', listaRespuesta[0].user_id);
                      Navigator.pushReplacement(context, MaterialPageRoute(builder: (context) => Home(),));
                    }
                    else{
                      const snackBar = SnackBar(content: Text('Usuario o Contraseña incorrectos'));
                      ScaffoldMessenger.of(context).showSnackBar(snackBar);
                    }
                    
                  }

                  
                  
                },
                                    
                child: const Text('Iniciar Sesión')),
          ],
          )
          ),
          
          SizedBox(height: 5),
          TextButton(
            onPressed: () {
              
            },
            child: Text('¿Olvidaste la contraseña?',style: TextStyle(decoration:TextDecoration.underline),),

          ),
          
          SizedBox(height: 15),
          TextButton(
            onPressed: () {
              Navigator.push(context, MaterialPageRoute(builder: (context)=> Registro(),));
            },
            child: Text('¿No tenes un usuario? Registrate',style: TextStyle(decoration:TextDecoration.underline),),

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

