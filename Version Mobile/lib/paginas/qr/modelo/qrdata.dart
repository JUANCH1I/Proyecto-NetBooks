
import 'package:mobile_scanner/mobile_scanner.dart';

class QrData{
  String? recurso_id;
  QrData({required this.recurso_id,});
  
  Map<String,dynamic> toJson(){
    return{
    'recurso_id': recurso_id,};
    
  }
}