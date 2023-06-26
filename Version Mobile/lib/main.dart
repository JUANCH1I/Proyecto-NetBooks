
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:Presma/paginas/home/ui/home.dart';
import 'package:Presma/paginas/login/ui/login.dart';

void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return ChangeNotifierProvider(
      create: (context) => MyAppState(),
      child: MaterialApp(
        
        debugShowCheckedModeBanner: false,
        title: 'Presma',
        theme: ThemeData(
          fontFamily: 'PTSansNarrow',
          useMaterial3: true,
          colorScheme: ColorScheme.fromSeed(seedColor: Color.fromARGB(255, 139, 178, 204)),
        ),
        home: Cargando(),
        
      ),
    );
  }
}

class MyAppState extends ChangeNotifier {
  var logueado = 0;
  String idusuario = '11';

  void cambiarLoginStatus(){
    logueado = 1;
    notifyListeners();
  }
  void setIdUsuario(nuevoID){
    idusuario = nuevoID;
    notifyListeners();
  }
}

class Cargando extends StatefulWidget{
  @override
  State<StatefulWidget> createState() {
    return CargandoState();
  }

}

class CargandoState extends State<Cargando>{
  @override
  Widget build(BuildContext context) {
    
    return Scaffold(
              body: buildBody(context),
            );
  }

  Widget buildBody(BuildContext context){
    
    return FutureBuilder(
      future: _login(),
      builder: (context, snapshot) {
        return Center(
          
          child: SafeArea(child: 
          Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              
              Image.asset('assets/et29.jpg', width: 200, height: 200,),
              SizedBox(height: 50,),
              CircularProgressIndicator(),
            ],
          ),
          )
          
        );
      },
    );
  }

  Future<String> _login() async {
    MyAppState().addListener(() => mounted ? setState(() {}) : null);
    await Future.delayed(Duration(seconds: 3)).then((value) {
      switch(MyAppState().logueado){
        case 0: 
          Navigator.pushReplacement(
        context,
        MaterialPageRoute(
          builder: (BuildContext context) {
            return Login();
          },
        ),
      );
        
        break;
      case 1:
        Navigator.pushReplacement(
        context,
        MaterialPageRoute(
          builder: (BuildContext context) {
            return Home();
          },
        ),
      );
      break;
      }
      
    });

    return "";
  }

}

 
  
  
