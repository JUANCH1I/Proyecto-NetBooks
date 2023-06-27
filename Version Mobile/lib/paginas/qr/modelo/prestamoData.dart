
class PrestamoData{
  int idregistro;
  String? recurso_id;
  String inicio_prestamo;
  String? fechas_extendidas;
  String? fin_prestamo;

  PrestamoData({required this.idregistro,
          required this.inicio_prestamo,
          required this.fechas_extendidas,
          required this.recurso_id,
           this.fin_prestamo,
          });

  factory PrestamoData.fromJson(Map<String, dynamic> json){
    return PrestamoData(
      idregistro: json['idregistro'],
      inicio_prestamo: json['inicio_prestamo'],
      fechas_extendidas: json['fechas_extendidas'],
      recurso_id: json['idrecurso'],
      fin_prestamo: json['fin_prestamo']);
  } 

  
}
  


 






























































  
