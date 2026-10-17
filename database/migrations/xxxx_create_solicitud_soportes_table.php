public function up(): void
{
    Schema::create('solicitudes_soporte', function (Blueprint $table) {
        $table->id();
        $table->string('solicitante');
        $table->string('departamento');
        $table->text('descripcion');
        $table->string('prioridad');
        $table->string('estado')->default('Pendiente');
        $table->timestamps();
    });
}