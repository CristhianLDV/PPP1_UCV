
📥 1. Clonar el Repositorio

Requisitos previos:

    Git instalado (Descargar Git)

    Node.js v18+ (Descargar Node.js)
    # Clona el repositorio desde GitHub
git clone https://github.com/TuUsuario/Sistema_Control_Asistencia-CMT.git

# Navega al directorio del proyecto
cd Sistema_Control_Asistencia-CMT

⚙️ 2. Configuración Inicial
Instalar dependencias:
npm install
# o
yarn install

Configurar variables de entorno:

    Copia el archivo .env.example a .env:
    cp .env.example .env
    Edita .env con tus credenciales (base de datos, API keys, etc.).

    🚀 3. Ejecutar el Proyecto
Modo desarrollo (con Vite):
bash

npm run dev

    Abre tu navegador en: http://localhost:5173

Modo producción (compilar assets):
bash

npm run build

