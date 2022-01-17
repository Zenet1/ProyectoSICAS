import { TestBed } from '@angular/core/testing';

import { AsistenciaExternoService } from './asistencia-externo.service';

describe('AsistenciaExternoService', () => {
  let service: AsistenciaExternoService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(AsistenciaExternoService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
