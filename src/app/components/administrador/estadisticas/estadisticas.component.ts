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

  single: any[];
  view: any[] = [700, 400];

  // options
  showXAxis: boolean = true;
  showYAxis: boolean = true;
  gradient: boolean = false;
  showLegend: boolean = true;
  showXAxisLabel: boolean = true;
  yAxisLabel: string = 'Licenciatura';
  showYAxisLabel: boolean = true;
  xAxisLabel: string = 'Cantidad';

  colorScheme = {
    domain: ['#5AA454', '#A10A28', '#C7B42C', '#AAAAAA']
  };

  constructor(private servicioAdmin:AdministradorService, private formBuilder:FormBuilder) { }

  ngOnInit(): void {
    this.formEstadisticas = this.formBuilder.group({
      tipo:[""],
      genero:[""],
      fechaInicio:[""],
      fechaFin:[""],
      programa:[""]
    });
    this.obtenerProgramas();
  }

  obtenerEstadisticas(){
    console.log(this.formEstadisticas.value);
    this.servicioAdmin.obtenerEstadisticas(this.formEstadisticas.value).subscribe(
      respuesta=>{
        this.estadisticas = respuesta;
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
}