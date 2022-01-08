import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { AdministradorService } from 'src/app/services/administrador/administrador.service';

@Component({
  selector: 'app-estadisticas',
  templateUrl: './estadisticas.component.html',
  styleUrls: ['./estadisticas.component.css']
})
export class EstadisticasComponent implements OnInit {
  formEstadisticas:FormGroup;
  programas:any;
  estadisticas:any;
  siEstadisticasObtenidas:boolean = false;
  // options
  showXAxis: boolean = true;
  showYAxis: boolean = true;
  gradient: boolean = false;
  showLegend: boolean = true;
  legendPosition: string = 'below';
  showXAxisLabel: boolean = true;
  yAxisLabel: string = 'Licenciatura';
  showYAxisLabel: boolean = true;
  xAxisLabel = 'Cantidad';
  colorScheme = { domain: ['#C68D2A']};
  schemeType: string = 'linear';

  constructor(private servicioAdmin:AdministradorService, private formBuilder:FormBuilder) { }

  ngOnInit(): void {
    this.formEstadisticas = this.formBuilder.group({
      tipo:[""],
      genero:[""],
      fechaInicio:[""],
      fechaFin:[""],
      programa:[""],
      NombrePlan:[""],
      ClavePlan:[""]
    });
    this.obtenerProgramas();
  }

  obtenerEstadisticas(){
    this.siEstadisticasObtenidas = false;
    if(this.formEstadisticas.controls["programa"].value != "todos"){
      this.formEstadisticas.controls["NombrePlan"].setValue(this.programas[this.formEstadisticas.controls["programa"].value].NombrePlan);
      this.formEstadisticas.controls["ClavePlan"].setValue(this.programas[this.formEstadisticas.controls["programa"].value].ClavePlan);
    } else {
      this.formEstadisticas.controls["NombrePlan"].setValue("todos");
      this.formEstadisticas.controls["ClavePlan"].setValue("todos");
    }
    this.servicioAdmin.obtenerEstadisticas(this.formEstadisticas.value).subscribe(
      respuesta=>{
        console.log(respuesta);
        if(respuesta.length > 0){
          this.estadisticas = respuesta;
          this.siEstadisticasObtenidas = true;
        } else {
          alert("No se encontraron estadísticas con los filtros seleccionados")
        }
      },
      error=>{
        alert("Ocurrió un error al obtener las estadísticas")
      }
    );
  }

  obtenerProgramas(){
    this.servicioAdmin.obtenerProgramas().subscribe(
      respuesta=>{
        this.programas = respuesta;
      }
    );
  }

  onActivate(event){

  }

  onDeactivate(event){

  }

  onSelect(event){

  }
}