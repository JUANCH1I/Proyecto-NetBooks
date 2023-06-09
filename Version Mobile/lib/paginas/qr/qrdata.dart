
class QrData{
  int idregistro;
  String idmaterial;
  String periodo_de_prestamo;
  String fechas_extendidas;

  QrData({required this.idregistro,
          required this.periodo_de_prestamo,
          required this.fechas_extendidas,
          required this.idmaterial});

  factory QrData.fromJson(Map<String, dynamic> json){
    return QrData(
      idregistro: json['idregistro'],
      periodo_de_prestamo: json['periodo_de_prestamo'],
      fechas_extendidas: json['fechas_extendidas'],
      idmaterial: json['idmaterial']);
  } 

  Map<String,dynamic> toJson(){
    return{
    'periodo_de_prestamo': periodo_de_prestamo,
    'fechas_extendidas': fechas_extendidas,
    'idmaterial': idmaterial,};
    
  }
}
  


  /*int idmaterial = 0; //QrScanState().barcode?.rawValue?.substring(0,5) as int;
  DateTime prestamo;
  void SetIdmaterial (String qr){
    
  }
  void SetPrestamo (String qr){
      prestamo = 
  }
  //QrScanState().barcode?.rawValue?.substring(5) as DateTime;
  // late DateTime prestamoextendido;
*/






























































  
