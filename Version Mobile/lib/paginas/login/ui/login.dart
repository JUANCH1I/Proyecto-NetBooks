
import 'package:flutter/material.dart';
import 'package:proyecto_notebooks/paginas/home/ui/home.dart';


class Login extends StatefulWidget {
  const Login({super.key});

  @override
  State<Login> createState() => LoginState();
}

class LoginState extends State<Login>{
    final _formKey = GlobalKey<FormState>();
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
            key: _formKey,
            child: Column(
              children: <Widget>[
              Padding(
              padding: EdgeInsets.symmetric(horizontal: 50, vertical: 16),
              child: TextField(
              decoration: InputDecoration(
                border: UnderlineInputBorder(),
                hintText: 'Mail',
                icon: Icon(Icons.person))
              )
              ),
              SizedBox(height: 10),
              Padding(
              padding: EdgeInsets.symmetric(horizontal: 50, vertical: 16),
              child: TextField(
              decoration: InputDecoration(
                border: UnderlineInputBorder(),
                hintText: 'Contraseña',
                icon: Icon(Icons.lock)))
              ),
              SizedBox(height: 15,),
              ElevatedButton(
                onPressed: () {
                  Navigator.push(context, MaterialPageRoute(builder: (context) => Home(),));
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
          SizedBox(height: 20),
          Center(
            child: Text('O iniciar sesión con:')),
         
          
         
           SizedBox(
            height: 60,
            
             child: IconButton(
              onPressed: () { 
              },
              icon: Image(
                image:AssetImage('assets/google.png'),
                height: 60,
                ),
              iconSize: 10,
             ),
           ),
         
          
        ],
        
      ),
    );
  }
  }