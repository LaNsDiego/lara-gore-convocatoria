<?php

use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\ModuleGroup;
use App\Models\PermissionSystem;
use App\Models\Province;
use App\Models\Role;
use App\Models\RoleHasPermission;
use App\Models\SystemModule;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // MODULE GROUPS
        // $grupo_home = ModuleGroup::create(['name' => 'Home']);
        $grupo_configuracion = ModuleGroup::create(['name' => 'Configuración']);
        $grupo_mantenimiento = ModuleGroup::create(['name' => 'Mantenimiento']);
        // $grupo_gestion = ModuleGroup::create(['name' => 'Gestión']);
        // $grupo_servicios = ModuleGroup::create(['name' => 'Servicios']);
        // $grupo_reportes_estadisticos = ModuleGroup::create(['name' => 'Reportes Estadísticos']);


        // GENERATING MODULE SYSTEMS
        $modulos = [
            // Home
            // ['name' => 'Reporte estadistico', 'description' => 'Módulo de administración de dashboard', 'module_group_id' => $grupo_home->id],

            // Configuración
            ['name' => 'Roles y permisos', 'description' => 'Módulo de administración de permisos', 'module_group_id' => $grupo_configuracion->id],
            ['name' => 'Usuarios', 'description' => 'Módulo de administración de usuarios', 'module_group_id' => $grupo_configuracion->id],

            // Mantenimiento
            ['name' => 'Cargo profesional', 'description' => 'Módulo de administración de títulos de trabajo', 'module_group_id' => $grupo_mantenimiento->id],
            ['name' => 'Perfiles convocatoria', 'description' => 'Módulo de perfiles laborales', 'module_group_id' => $grupo_mantenimiento->id],   
            ['name' => 'Requerimiento personal', 'description' => 'Módulo de requerimientos', 'module_group_id' => $grupo_mantenimiento->id],       
            ['name' => 'Datos personales', 'description' => 'Módulo de empleados', 'module_group_id' => $grupo_mantenimiento->id]            

            // Reportes Detallados
            // ['name' => 'Reporte de Actividades', 'description' => 'Módulo de administración de reporte de actividades', 'module_group_id' => $grupo_reportes_estadisticos->id],

        ];


        $actions = ['crear', 'leer', 'editar', 'eliminar','cerrar'];
        // Create modules and permissions
        $permissions = [];
        foreach ($modulos as $modulo) {
            $createdModule = SystemModule::create($modulo);
            foreach($actions as $action) {
                $permission = PermissionSystem::create([
                    'action' => Str::slug(strtolower($createdModule->name))."-$action",
                    'system_module_id' => $createdModule->id,
                ]);
                $permissions[] = $permission;
            }
        }

        $role_admin = Role::create(['name' => 'ADMINISTRADOR']);
        foreach ($permissions as $permission) {
            RoleHasPermission::create([
                'role_id' => $role_admin->id,
                'permission_id' => $permission->id,
                'has_access' => true
            ]);
        }

        $admin = User::create([
            'name' => 'Administrador',
            'dni' => '00000000',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123123123'),
            'role_id' => $role_admin->id
        ]);


        

        Country::create(['name' => 'Perú']);
        
        $departamentos = [
            'Amazonas',
            'Ancash',
            'Apurímac',
            'Arequipa',
            'Ayacucho',
            'Cajamarca',
            'Callao',
            'Cusco',
            'Huancavelica',
            'Huánuco',
            'Ica',
            'Junín',
            'La Libertad',
            'Lambayeque',
            'Lima',
            'Loreto',
            'Madre de Dios',
            'Moquegua',
            'Pasco',
            'Piura',
            'Puno',
            'San Martín',
            'Tacna',
            'Tumbes',
            'Ucayali'
        ];

        foreach ($departamentos as $departamento) {
            Department::create(['name' => $departamento,'country_id' => 1]);
        }



        $provincias = [
            'Amazonas' => ['Chachapoyas', 'Bagua', 'Bongará', 'Condorcanqui', 'Luya', 'Rodríguez de Mendoza', 'Utcubamba'],
            'Ancash' => ['Huaraz', 'Aija', 'Antonio Raymondi', 'Asunción', 'Bolognesi', 'Carhuaz', 'Carlos Fermín Fitzcarrald', 'Casma', 'Corongo', 'Huari', 'Huarmey', 'Huaylas', 'Mariscal Luzuriaga', 'Ocros', 'Pallasca', 'Pomabamba', 'Recuay', 'Santa', 'Sihuas', 'Yungay'],
            'Apurímac' => ['Abancay', 'Andahuaylas', 'Antabamba', 'Aymaraes', 'Cotabambas', 'Grau', 'Chincheros'],
            'Arequipa' => ['Arequipa', 'Camaná', 'Caravelí', 'Castilla', 'Caylloma', 'Condesuyos', 'Islay', 'La Unión'],
            'Ayacucho' => ['Huamanga', 'Cangallo', 'Huanca Sancos', 'Huanta', 'La Mar', 'Lucanas', 'Parinacochas', 'Páucar del Sara Sara', 'Sucre', 'Víctor Fajardo', 'Vilcas Huamán'],
            'Cajamarca' => ['Cajamarca', 'Cajabamba', 'Celendín', 'Chota', 'Contumazá', 'Cutervo', 'Hualgayoc', 'Jaén', 'San Ignacio', 'San Marcos', 'San Miguel', 'San Pablo', 'Santa Cruz'],
            'Callao' => ['Prov. Const. del Callao'],
            'Cusco' => ['Cusco', 'Acomayo', 'Anta', 'Calca', 'Canas', 'Canchis', 'Chumbivilcas', 'Espinar', 'La Convención', 'Paruro', 'Paucartambo', 'Quispicanchi', 'Urubamba'],
            'Huancavelica' => ['Huancavelica', 'Acobamba', 'Angaraes', 'Castrovirreyna', 'Churcampa', 'Huaytará', 'Tayacaja'],
            'Huánuco' => ['Huánuco', 'Ambo', 'Dos de Mayo', 'Huacaybamba', 'Huamalíes', 'Leoncio Prado', 'Marañón', 'Pachitea', 'Puerto Inca', 'Lauricocha', 'Yarowilca'],
            'Ica' => ['Ica', 'Chincha', 'Nazca', 'Palpa', 'Pisco'],
            'Junín' => ['Huancayo', 'Concepción', 'Chanchamayo', 'Jauja', 'Junín', 'Satipo', 'Tarma', 'Yauli', 'Chupaca'],
            'La Libertad' => ['Trujillo', 'Ascope', 'Bolívar', 'Chepén', 'Julcán', 'Otuzco', 'Pacasmayo', 'Pataz', 'Sánchez Carrión', 'Santiago de Chuco', 'Gran Chimú', 'Virú'],
            'Lambayeque' => ['Chiclayo', 'Ferreñafe', 'Lambayeque'],
            'Lima' => ['Lima', 'Barranca', 'Cajatambo', 'Canta', 'Cañete', 'Huaral', 'Huarochirí', 'Huaura', 'Oyón', 'Yauyos'],
            'Loreto' => ['Maynas', 'Alto Amazonas', 'Loreto', 'Mariscal Ramón Castilla', 'Requena', 'Ucayali', 'Datem del Marañón', 'Putumayo'],
            'Madre de Dios' => ['Tambopata', 'Manu', 'Tahuamanu'],
            'Moquegua' => ['Mariscal Nieto', 'General Sánchez Cerro', 'Ilo'],
            'Pasco' => ['Pasco', 'Daniel Alcides Carrión', 'Oxapampa'],
            'Piura' => ['Piura', 'Ayabaca', 'Huancabamba', 'Morropón', 'Paita', 'Sullana', 'Talara', 'Sechura'],
            'Puno' => ['Puno', 'Azángaro', 'Carabaya', 'Chucuito', 'El Collao', 'Huancané', 'Lampa', 'Melgar', 'Moho', 'San Antonio de Putina', 'San Román', 'Sandia', 'Yunguyo'],
            'San Martín' => ['Moyobamba', 'Bellavista', 'El Dorado', 'Huallaga', 'Lamas', 'Mariscal Cáceres', 'Picota', 'Rioja', 'San Martín', 'Tocache'],
            'Tacna' => ['Tacna', 'Candarave', 'Jorge Basadre', 'Tarata'],
            'Tumbes' => ['Tumbes', 'Contralmirante Villar', 'Zarumilla'],
            'Ucayali' => ['Coronel Portillo', 'Atalaya', 'Padre Abad', 'Purús']
        ];

        foreach ($provincias as $departamento => $provincias) {
            $departamento_obj = Department::where('name', $departamento)->first();
        
            if ($departamento_obj) {
                $departamento_id = $departamento_obj->id;
        
                foreach ($provincias as $provincia) {
                    Province::create([
                        'name' => $provincia,
                        'department_id' => $departamento_id,
                    ]);
                }
            } else {
                // Maneja el caso en que el departamento no se encuentra
                echo "El departamento '$departamento' no fue encontrado en la base de datos.\n";
            }
        }

        $distritos = [
            'Amazonas' => [
                'Chachapoyas' => ['Chachapoyas', 'Bagua', 'Bongara', 'Condorcanqui', 'Luya', 'Rodriguez de Mendoza', 'Utcubamba'],
                'Bagua' => ['Bagua', 'Cajaruro', 'Colasay', 'El Parco', 'Imazita', 'La Peca', 'Lonya Chico', 'San Ignacio', 'San Jose', 'San Nicolas', 'Tabaconas', 'Uchumarca', 'Yambrasbamba'],
                'Bongara' => ['Jumbilla', 'Churuja', 'Cuispes', 'Gonzalo Fernandez de Oviedo', 'Jazan', 'Longuita', 'Naranjos', 'San Carlos', 'San Ignacio', 'San Juan', 'San Nicolas', 'Tingo'],
                'Condorcanqui' => ['Nieva', 'El Cenepa', 'Rio Santiago'],
                'Luya' => ['Camporredondo', 'Cocos', 'Conila', 'Luya', 'Luya Viejo', 'Longuita', 'San Francisco del Yeso', 'San Jeronimo', 'San Juan de Lopecancha', 'San Pedro', 'Santa Catalina', 'Santa Rosa'],
                'Rodriguez de Mendoza' => ['Cocabamba', 'Chuquibamba', 'La Florida', 'Mendoza', 'Omia', 'San Nicolas', 'Santa Rosa'],
                'Utcubamba' => ['Bagua Grande', 'Cajaruro', 'Colasay', 'El Parco', 'Imazita', 'La Peca', 'Lonya Chico', 'San Ignacio', 'San Jose', 'San Nicolas', 'Tabaconas', 'Uchumarca', 'Yambrasbamba'],
            ],
            'Ancash' => [
                'Huaraz' => ['Huaraz', 'Colcabamba', 'Cochabamba', 'Independencia', 'Jangas', 'Olleros', 'Pampas', 'Pariahuanca', 'San Luis', 'San Marcos', 'San Pedro', 'Shupluy', 'Villa San Francisco'],
                'Aija' => ['Aija', 'Cajacay', 'Coris', 'Huacachi', 'La Merced', 'Lima', 'Mache', 'San Juan de Rontoy', 'Santiago de Chilca'],
                'Antonio Raymondi' => ['Chacas', 'San Luis', 'San Pedro', 'Santa Rosa', 'Yungay'],
                'Asuncion' => ['Asuncion', 'Anta', 'Cajamarquilla', 'Chancas', 'Cipriani', 'Colquioc', 'Huachis', 'Mancos', 'Matriz', 'Mochaccsa', 'Santa', 'Santa Cruz'],
                'Bolognesi' => ['Aco', 'Aczo', 'Anta', 'Cajacay', 'Carmen', 'Chavin', 'Colquioc', 'Huaylas', 'Mendez', 'Olleros', 'Santa Rosa', 'Tingo'],
                'Carhuaz' => ['Carhuaz', 'Acopampa', 'Anta', 'Carmen', 'Chancos', 'Huachis', 'Marcara', 'Matos', 'Santa Ana'],
                'Carlos Fermín Fitzcarrald' => ['Yungay', 'Vicos', 'San Luis', 'Chavin', 'Ticapampa'],
                'Casma' => ['Casma', 'Buena Vista Alta', 'Carmen de la Legua', 'Tantara'],
                'Corongo' => ['Corongo', 'Santa Rosa', 'Challhuapampa', 'Cachipampa'],
                'Huari' => ['Huari', 'Anta', 'Aquia', 'Huachis', 'Mancos', 'Pampas', 'San Marcos', 'Santa Rosa'],
                'Huarmey' => ['Huarmey', 'Culebras', 'La Florida', 'San Juan'],
                'Huaylas' => ['Huaylas', 'Caraz', 'Santa Ana', 'Yungay'],
                'Mariscal Luzuriaga' => ['Llamellin', 'San Juan de Rontoy', 'Santa Rosa'],
                'Ocros' => ['Ocros', 'Huallanca', 'San Juan de Rontoy'],
                'Pallasca' => ['Pallasca', 'Cabana', 'Pampas', 'Santa Rosa'],
                'Pomabamba' => ['Pomabamba', 'Bolognesi', 'Huancaspata'],
                'Recuay' => ['Recuay', 'Catac', 'La Merced', 'Yumbatos'],
                'Santa' => ['Santa', 'Chimbote', 'Samanco'],
                'Sihuas' => ['Sihuas', 'Chingas', 'Matriz'],
                'Yungay' => ['Yungay', 'Caraz', 'Santa Ana', 'San Miguel'],
            ],
            'Apurímac' => [
                'Abancay' => ['Abancay', 'Circa', 'Huanipaca', 'Pampachiri', 'San Pedro de Cachora'],
                'Andahuaylas' => ['Andahuaylas', 'Chincheros', 'Huancarama', 'San Jeronimo', 'San Pedro'],
                'Antabamba' => ['Antabamba', 'El Oro', 'Huaquillas', 'Sabancaya', 'Sayan'],
                'Aymaraes' => ['Aymaraes', 'Chalhuanca', 'Curasco', 'Huarango', 'Las Bambas'],
                'Cotabambas' => ['Cotabambas', 'Challhuahuacho', 'Huanipaca', 'Machu Picchu', 'Tambo'],
            ],
            'Arequipa' => [
                'Arequipa' => ['Arequipa', 'Cayma', 'Characato', 'Jose Luis Bustamante y Rivero', 'La Joya'],
                'Camana' => ['Camana', 'Ocoña', 'Samuel Pastor', 'Mariano Nicolás Valcárcel'],
                'Caraveli' => ['Caraveli', 'Acarí', 'Acari', 'Chocayhua', 'Yanaquihua'],
                'Caylloma' => ['Caylloma', 'Chivay', 'Cabanaconde', 'Tapay', 'Yanque'],
                'Condesuyos' => ['Chuquibamba', 'Iberia', 'La Colca', 'Nina', 'Ninobamba'],
                'Islay' => ['Islay', 'Mollendo', 'Mejía', 'Vítor', 'Camaná'],
                'La Union' => ['La Union', 'Camas', 'Huayllabamba', 'Sayan', 'Yanque'],
            ],
            'Ayacucho' => [
                'Ayacucho' => ['Ayacucho', 'Carmen Alto', 'El Carmen', 'Jesús Nazareno', 'San Juan Bautista'],
                'Cangallo' => ['Cangallo', 'Los Morochucos', 'San José', 'Santa Ana', 'Santa Rosa'],
                'Huanta' => ['Huanta', 'Huamanguilla', 'San Miguel', 'Santa Rosa', 'Santa Rosa'],
                'Huamanga' => ['Huamanga', 'San Juan de Miraflores', 'Santa Ana', 'Santa Rosa', 'Yanacocha'],
                'La Mar' => ['La Mar', 'El Carmen', 'Huanta', 'Santa Ana', 'Santa Rosa'],
                'Lucanas' => ['Lucanas', 'San Pedro de Lucanas', 'San Juan de Lucanas', 'Santa Rosa', 'Sancos'],
                'Páucar del Sara Sara' => ['Paucar del Sara Sara', 'San Pedro', 'San Juan', 'Santa Rosa', 'Sancos'],
                'Sucre' => ['Sucre', 'San Salvador', 'Santa Ana', 'Santa Rosa', 'Sancos'],
            ],
            'Cajamarca' => [
                'Cajamarca' => ['Cajamarca', 'Banos del Inca', 'Cajabamba', 'Chancaybanos', 'Chota'],
                'Chota' => ['Chota', 'Llama', 'Llama', 'Santa Rosa', 'Santo Tomas'],
                'Celendin' => ['Celendin', 'Chumuch', 'Granada', 'Jose Galvez', 'San Juan'],
                'Hualgayoc' => ['Hualgayoc', 'Bambamarca', 'Cajamarca', 'Chancay', 'La Encanada'],
                'Jaen' => ['Jaen', 'San Ignacio', 'San Jose del Alto', 'Santa Rosa', 'Yamal'],
                'San Miguel' => ['San Miguel', 'San Juan de Cutervo', 'Santa Rosa', 'Santa Teresa'],
                'San Pablo' => ['San Pablo', 'Chota', 'Llama', 'Santa Rosa', 'Santo Tomas'],
                'San Marcos' => ['San Marcos', 'Chota', 'Llama', 'Santa Rosa', 'Santo Tomas'],
                'San Ignacio' => ['San Ignacio', 'Jaen', 'San Jose del Alto', 'Santa Rosa', 'Yamal'],
                'San Pablo' => ['San Pablo', 'San Jose', 'Santa Rosa', 'Santo Tomas'],
            ],
            'Callao' => [
                'Callao' => ['Callao', 'La Perla', 'La Punta', 'Ventanilla'],
            ],
            'Cusco' => [
                'Cusco' => ['Cusco', 'San Sebastian', 'San Jeronimo', 'Santiago', 'Wanchaq'],
                'Acomayo' => ['Acomayo', 'Coya', 'Pomacanchi', 'San Salvador', 'Santo Tomas'],
                'Anta' => ['Anta', 'Chinchero', 'Huarocondo', 'Mollepata', 'Rondocancha'],
                'Calca' => ['Calca', 'Coya', 'Lamay', 'Pisac', 'San Salvador'],
                'Canas' => ['Canas', 'Yanaoca', 'Sicuani', 'Marangani', 'Pampamarca'],
                'Canchis' => ['Canchis', 'Sicuani', 'San Pablo', 'San Pedro', 'Tinta'],
                'Espinar' => ['Espinar', 'Ccarhuayo', 'Ccapara', 'Pichigua', 'Yauri'],
                'La Convencion' => ['La Convencion', 'Santa Teresa', 'Santa Ana', 'Vila', 'Pichari'],
                'Paruro' => ['Paruro', 'Accha', 'Ccapacmarca', 'Huaro', 'San Pablo'],
                'Quispicanchi' => ['Quispicanchi', 'Andahuaylillas', 'Ccarhuayo', 'Coya', 'San Salvador'],
                'Urubamba' => ['Urubamba', 'Ollantaytambo', 'Yucay', 'Maras', 'Chinchero'],
            ],
            'Huancavelica' => [
                'Huancavelica' => ['Huancavelica', 'Ascension', 'Castrovirreyna', 'Huancaya', 'Huancapi'],
                'Angaraes' => ['Angaraes', 'Acolla', 'Aco', 'Lircay', 'Ticrapo'],
                'Churcampa' => ['Churcampa', 'Paucarbamba', 'San Pedro de Cajas', 'Santa Ana', 'Santa Rosa'],
                'Castrovirreyna' => ['Castrovirreyna', 'Huancaya', 'Pachamarca', 'San Juan', 'Santa Ana'],
                'Huancayo' => ['Huancayo', 'El Tambo', 'Chupaca', 'Concepcion', 'Jauja'],
                'Jauja' => ['Jauja', 'San Juan de Jarpa', 'Tunanmarca', 'Yauyos', 'Acolla'],
                'Yauli' => ['Yauli', 'La Oroya', 'Ondores', 'San Francisco', 'San Mateo'],
            ],
            'Huánuco' => [
                'Huanuco' => ['Huanuco', 'Pillco Marca', 'Chinchao', 'San Francisco', 'Yarumayo'],
                'Ambo' => ['Ambo', 'Cajamarquilla', 'San Rafael', 'San Vicente', 'Tingo'],
                'Dos de Mayo' => ['Dos de Mayo', 'Rondos', 'Yacus', 'Jangara', 'San Miguel'],
                'Huacaybamba' => ['Huacaybamba', 'Chavin', 'Moya', 'Pucayacu', 'San Juan'],
                'Huanuco' => ['Huanuco', 'Pillco Marca', 'Chinchao', 'San Francisco', 'Yarumayo'],
                'Leoncio Prado' => ['Leoncio Prado', 'Huacrachuco', 'San Luis', 'San Pedro', 'San Vicente'],
                'Pachitea' => ['Pachitea', 'Panao', 'San Francisco', 'San Rafael', 'San Vicente'],
                'Puerto Inca' => ['Puerto Inca', 'Inca', 'Pucayacu', 'San Jose', 'San Vicente'],
                'Rupa Rupa' => ['Rupa Rupa', 'Acomayo', 'San Jose', 'San Rafael', 'San Vicente'],
            ],
            'Ica' => [
                'Ica' => ['Ica', 'Parcona', 'Los Aquijes', 'San Juan Bautista', 'La Tinguiña'],
                'Chincha' => ['Chincha', 'Chincha Alta', 'Chincha Baja', 'El Carmen', 'San Juan de Lurigancho'],
                'Nazca' => ['Nazca', 'Marcona', 'Palpa', 'San Juan Bautista', 'San Pedro'],
                'Palpa' => ['Palpa', 'Llipata', 'Palpa', 'San Juan', 'San Pedro'],
                'Vita' => ['Vita', 'Salas', 'Santa Rosa', 'San Juan', 'San Pedro'],
            ],
            'Junín' => [
                'Huancayo' => ['Huancayo', 'El Tambo', 'Concepcion', 'Jauja', 'Chupaca'],
                'Chupaca' => ['Chupaca', 'El Tambo', 'Huancayo', 'San Agustin', 'San Pedro'],
                'Jauja' => ['Jauja', 'Acolla', 'San Agustin', 'San Pedro', 'Yauyos'],
                'La Oroya' => ['La Oroya', 'Yauli', 'San Francisco', 'Ondores', 'Paca'],
                'Pasco' => ['Pasco', 'San Francisco', 'Santa Ana', 'Santa Rosa', 'San Pedro'],
                'Satipo' => ['Satipo', 'San Juan', 'Rondos', 'San Vicente', 'Tingo María'],
                'Tarma' => ['Tarma', 'San Pedro', 'San Vicente', 'San Francisco', 'San Agustin'],
                'Yauli' => ['Yauli', 'La Oroya', 'San Francisco', 'Santa Ana', 'Santa Rosa'],
            ],
            'La Libertad' => [
                'Trujillo' => ['Trujillo', 'El Porvenir', 'La Esperanza', 'San Andres', 'San Juan'],
                'Ascope' => ['Ascope', 'Chicama', 'Julcan', 'Paiján', 'Santiago de Cao'],
                'Bolívar' => ['Bolívar', 'Balsas', 'Condorcanqui', 'Jumbilla', 'La Union'],
                'Chepén' => ['Chepen', 'Pacasmayo', 'San Pedro', 'San Jose', 'San Francisco'],
                'Gran Chimú' => ['Gran Chimu', 'Chicama', 'La Esperanza', 'San Andres', 'San Juan'],
                'Julcán' => ['Julcan', 'San Carlos', 'San Juan', 'Santa Rosa', 'San Pedro'],
                'Otuzco' => ['Otuzco', 'Huamachuco', 'San Juan', 'San Pedro', 'San Pablo'],
                'Pacasmayo' => ['Pacasmayo', 'San Pedro', 'San Juan', 'Santa Rosa', 'San Francisco'],
                'Pataz' => ['Pataz', 'Chilia', 'Shubia', 'San Pedro', 'San Juan'],
                'Santiago de Chuco' => ['Santiago de Chuco', 'San Juan', 'San Pedro', 'Santa Ana', 'Santa Rosa'],
                'Virú' => ['Virú', 'San Pedro', 'San Juan', 'Santa Ana', 'Santa Rosa'],
            ],
            'Lambayeque' => [
                'Chiclayo' => ['Chiclayo', 'Cayalti', 'Chongoyape', 'Lambayeque', 'Monsefú'],
                'Ferreñafe' => ['Ferreñafe', 'Cañaris', 'Pítipo', 'San Fernando', 'San Juan'],
                'Lambayeque' => ['Lambayeque', 'Chiclayo', 'José Leonardo Ortiz', 'Monsefú', 'Pítipo'],
            ],
            'Lima' => [
                'Lima' => ['Lima', 'San Isidro', 'Miraflores', 'Barranco', 'San Borja'],
                'Callao' => ['Callao', 'La Perla', 'La Punta', 'Ventanilla'],
                'Huaral' => ['Huaral', 'Aucallama', 'Chancay', 'Huascar', 'Sumbilca'],
                'Huarochiri' => ['Huarochiri', 'Matucana', 'San Mateo', 'San Pedro', 'Santa Eulalia'],
                'Huascarán' => ['Huascaran', 'Huaraz', 'Caraz', 'Mancos', 'Yungay'],
                'Lima Provincias' => ['Canta', 'Huaral', 'Huacho', 'Lima', 'Matucana'],
                'Lima Metropolitana' => ['Lima', 'Callao', 'Cercado de Lima', 'Miraflores', 'San Isidro'],
                'Oyon' => ['Oyon', 'Canta', 'San Pedro de Casta', 'San Juan de Lurigancho', 'Santa Rosa'],
                'Yauyos' => ['Yauyos', 'Cahuach', 'San Bartolome', 'San Juan de Lurigancho', 'Santa Rosa'],
            ],
            'Loreto' => [
                'Iquitos' => ['Iquitos', 'Punchana', 'Belén', 'Fernando Lores', 'San Juan'],
                'Requena' => ['Requena', 'Begoes', 'Jenaro Herrera', 'Río Napo', 'Yurimaguas'],
                'Alto Amazonas' => ['Alto Amazonas', 'Yurimaguas', 'Balsapuerto', 'Moyobamba', 'Río Santiago'],
                'Mariscal Ramón Castilla' => ['Mariscal Ramón Castilla', 'Caballo Cocha', 'Yavari', 'Río Putumayo', 'Río Napo'],
                'Datem del Marañón' => ['Datem del Marañón', 'Santa María de Nieva', 'Río Marañón', 'Río Santiago', 'Río Napo'],
            ],
            'Madre de Dios' => [
                'Madre de Dios' => ['Puerto Maldonado', 'Tambopata', 'Inambari', 'Tahuamanu', 'Manu'],
            ],
            'Moquegua' => [
                'Moquegua' => ['Moquegua', 'Ilo', 'Omate', 'San Antonio', 'San Cristobal'],
            ],
            'Pasco' => [
                'Pasco' => ['Pasco', 'Chaupimarca', 'Colquijirca', 'San Francisco', 'San Juan'],
                'Daniel Alcides Carrión' => ['Daniel Alcides Carrión', 'Chaupimarca', 'San Pedro', 'San Juan', 'Santa Ana'],
            ],
            'Piura' => [
                'Piura' => ['Piura', 'Castilla', 'Catacaos', 'La Arena', 'Sullana'],
                'Sullana' => ['Sullana', 'Bellavista', 'El Arenal', 'Marcavelica', 'Talara'],
                'Talara' => ['Talara', 'El Alto', 'La Balsa', 'Los Organos', 'Máncora'],
            ],
            'Puno' => [
                'Puno' => ['Puno', 'Juliaca', 'San Román', 'San Antonio de Putina', 'Yunguyo'],
                'Azángaro' => ['Azángaro', 'San Antón', 'San José de Llanga', 'San Juan de Salinas', 'San Pedro de Putina Punco'],
                'Carabaya' => ['Carabaya', 'Macusani', 'Ajoyani', 'San Gabán', 'San Juan de Salinas'],
                'Chucuito' => ['Chucuito', 'Desaguadero', 'Pucarani', 'San Pedro de Tiquillaca', 'Yunguyo'],
                'El Collao' => ['El Collao', 'Ilave', 'San Antonio', 'San Pedro', 'Santa Rosa'],
                'Lampa' => ['Lampa', 'Ajoyani', 'Carabaya', 'San Antón', 'San Pedro de Putina Punco'],
                'San Antonio de Putina' => ['San Antonio de Putina', 'San Gabán', 'San Juan de Salinas', 'San Pedro', 'Santa Rosa'],
                'Yunguyo' => ['Yunguyo', 'Desaguadero', 'Ilave', 'San Pedro de Tiquillaca', 'Santa Rosa'],
            ],
            'San Martín' => [
                'San Martín' => ['San Martín', 'Tarapoto', 'Juanjuí', 'Moyobamba', 'Pucallpa'],
                'Bellavista' => ['Bellavista', 'San José de Sisa', 'San Vicente', 'San Pedro', 'San Juan'],
                'El Dorado' => ['El Dorado', 'San Juan', 'San Pedro', 'San Vicente', 'San José'],
                'Moyobamba' => ['Moyobamba', 'San Antonio', 'San José', 'San Martín', 'San Pedro'],
                'Pachiza' => ['Pachiza', 'San Martín', 'San José', 'San Vicente', 'San Pedro'],
            ],
            'Tacna' => [
                'Tacna' => [
                    'Tacna',
                    'Alto de la Alianza',
                    'Calana',
                    'Ciudad Nueva',
                    'Inclán',
                    'Pachía',
                    'Palca',
                    'Pocollay',
                    'Sama',
                    'Gregorio Albarracín',
                    'La Yarada-Los Palos'
                ],
                'Tarata' => [
                    'Tarata',
                    'Estique',
                    'Estique Pampa',
                    'Héroes Albarracín',
                    'Sitajara',
                    'Susapaya',
                    'Tarucachi',
                    'Ticaco'
                ],
                'Jorge Basadre' => [
                    'Ilabaya',
                    'Ite',
                    'Locumba'
                ],
                'Candarave' => [
                    'Candarave',
                    'Cairani',
                    'Camilaca',
                    'Curibaya',
                    'Huanuara',
                    'Quilahuani'
                ]

            ],
            'Tumbes' => [
                'Tumbes' => ['Tumbes', 'Zorritos', 'Casitas', 'Corrales', 'San Jacinto'],
                'Zarumilla' => ['Zarumilla', 'Aguas Verdes', 'Canoas de Punta Sal', 'La Tina', 'Pampa Grande'],
            ],
            'Ucayali' => [
                'Ucayali' => ['Ucayali', 'Pucallpa', 'Yarinacocha', 'Calleria', 'Campo Verde'],
                'Atalaya' => ['Atalaya', 'Puerto Atalaya', 'Requena', 'San Juan', 'Tournavista'],
                'Coronel Portillo' => ['Coronel Portillo', 'Pucallpa', 'Yarinacocha', 'Campo Verde', 'Calleria'],
            ],
        ];

        foreach ($distritos as $departamentoNombre => $provincias) {
            $departamento = Department::where('name', $departamentoNombre)->first();

            if ($departamento) {
                foreach ($provincias as $provinciaNombre => $distritos) {
                    $provincia = Province::where('name', $provinciaNombre)
                        ->where('department_id', $departamento->id)
                        ->first();

                    if ($provincia) {
                        foreach ($distritos as $distritoNombre) {
                            City::updateOrCreate([
                                'name' => $distritoNombre,
                                'province_id' => $provincia->id,
                            ]);
                        }
                    }
                }
            }
        }
    }
}
