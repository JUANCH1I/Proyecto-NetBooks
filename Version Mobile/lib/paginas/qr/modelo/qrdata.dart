
class QrData{
  String? recurso_id;
  String? idusuario;
  QrData({required this.recurso_id,
          required this.idusuario});
  
  Map<String,dynamic> toJson(){
    return{
    'recurso_id': recurso_id,
    'idusuario': idusuario,};
    
  }
}