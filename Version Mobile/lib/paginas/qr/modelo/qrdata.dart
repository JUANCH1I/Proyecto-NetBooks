
class QrData{
  String? recurso_id;
  String? idusuario;
  String? fecha;
  QrData({required this.recurso_id,
          required this.idusuario,
          this.fecha});
  
  Map<String,dynamic> toJson(){
    return{
    'recurso_id': recurso_id,
    'idusuario': idusuario,
    'fecha': fecha};
    
  }
}