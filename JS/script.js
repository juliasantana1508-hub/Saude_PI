/* ==== TOGGLE THEME ==== */
const toggleTheme = document.getElementById("toggle-theme");

function setTheme(theme) {
  const logo = document.getElementById("logo-site");

  if (theme === "dark") {
    document.body.classList.add("dark-mode");
    toggleTheme.textContent = "☀️ Modo Claro";

    // Trocar logo no modo escuro
    logo.src = "./Img/logo-escura.png";

  } else {
    document.body.classList.remove("dark-mode");
    toggleTheme.textContent = "🌙 Modo Escuro";

    // Trocar logo no modo claro
    logo.src = "./Img/logo-clara.png";
  }

  localStorage.setItem("theme", theme);
}

// Carregar tema salvo
setTheme(localStorage.getItem("theme") || "light");

// Alternar tema ao clicar
toggleTheme.addEventListener("click", () => {
  const isDark = document.body.classList.contains("dark-mode");
  setTheme(isDark ? "light" : "dark");
});


/* ==== DROPDOWN MENU (o que você mandou, intacto) ==== */
const configBtn = document.getElementById("config-btn");
const dropdown = document.querySelector(".config-menu .dropdown");
const accessibilityToggle = document.getElementById("accessibility");
const subDropdown = document.querySelector(".submenu .sub-dropdown");

configBtn.addEventListener("click", (e) => {
  e.stopPropagation();
  const isOpen = dropdown.style.display === "flex";
  dropdown.style.display = isOpen ? "none" : "flex";
  dropdown.style.flexDirection = "column";

  if (subDropdown) {
    subDropdown.style.display = "none";
    accessibilityToggle.setAttribute("aria-expanded", "false");
  }
});

document.addEventListener("click", (e) => {
  if (!e.target.closest(".config-menu")) {
    dropdown.style.display = "none";
    if (subDropdown) subDropdown.style.display = "none";
    configBtn.setAttribute("aria-expanded", "false");
    if (accessibilityToggle) accessibilityToggle.setAttribute("aria-expanded", "false");
  }
});

accessibilityToggle.addEventListener("click", (e) => {
  e.stopPropagation();
  const isOpen = subDropdown.style.display === "flex";
  subDropdown.style.display = isOpen ? "none" : "flex";
  accessibilityToggle.setAttribute("aria-expanded", !isOpen);
});

document.addEventListener("click", (e) => {
  if (!e.target.closest(".config-menu")) {
    dropdown.style.display = "none";
    subDropdown.style.display = "none";
    configBtn.setAttribute("aria-expanded", "false");
    accessibilityToggle.setAttribute("aria-expanded", "false");
  }
});


/* END DARK/LIGHT MODE*/

/*  TRADUÇÃO BÁSICA */

const langBtn = document.getElementById("change-lang");

const translations = {
  pt: {
    home: "Home",
    monitoring: "Monitoramento",
    history: "Histórico",
    services: "Serviços",
    about: "Quem somos",
    login: "Login",
    settings: "⚙️",
    darkMode: "🌙 Modo Escuro",
    lightMode: "☀️ Modo Claro",
    accessibility: "♿ Acessibilidade",
    changeLang: "🌎 Trocar Idioma",

    //Home
    title: "Bem-vindo ao Bem-Estar 360!",
    text1: "Monitore sua saúde diariamente e acompanhe seu bem-estar de forma simples, intuitiva e confiável.",
    text2: "Nosso objetivo é ajudá-lo a compreender seu corpo, adotando hábitos saudáveis e prevenindo riscos.",
    text3: "Registre seus dados de saúde",
    text4:"Para manter seu acompanhamento atualizado, clique nos cards abaixo e registre suas medições de pressão arterial, glicemia, batimentos cardíacos e temperatura. O registro diário ajuda você e os profissionais de saúde a monitorarem seu bem-estar com mais precisão.",
    cardPress: "Pressão Arterial",
    cardPressP: "Registre e acompanhe seus valores de pressão arterial.",
    cardPressA: "Registre sua Pressão Arterial",
    cardGlicemia: "Glicemia",
    cardGlicemiaP: "Registre e acompanhe seus níveis de glicose no sangue.",
    cardGlicemiaA: "Registrar Glicemia",
    cardBatimentos: "Batimentos Cardíacos",
    cardBatimentosP: "Registre e acompanhe sua frequência cardíaca.",
    cardBatimentosA: "Registrar Batimentos",
    cardTemperatura: "Temperatura",
    cardTemperaturaP: "Registre e acompanhe sua temperatura corporal.",
    cardTemperaturaA: "Registrar Temperatura",
    newsTitle: "Últimas notícias sobre saúde",
    newsTagSUS: "#Sus",
    newsTitleSUS: "SUS garante atendimento de qualidade a todos os brasileiros",
    newsTextSUS: "O Sistema Único de Saúde (SUS) continua oferecendo atendimento gratuito, promovendo prevenção, tratamentos e acompanhamento em diversas áreas da saúde, reforçando seu papel essencial na vida da população.",
    newsTagDiabetes: "#Diabete",
    newsTitleDiabetes: "Diabetes exige acompanhamento e cuidados contínuos",
    newsTextDiabetes: "O diabetes é uma doença crônica que exige atenção diária à alimentação, atividade física e controle médico. O diagnóstico precoce é essencial para evitar complicações graves.",
    newsTagSexualHealth: "#Saúde Sexual",
    newsTitleSexualHealth: "Saúde sexual: importância da prevenção e bem-estar",
    newsTextSexualHealth: "Especialistas alertam sobre a necessidade de cuidados com a saúde sexual, que envolve bem-estar físico, emocional e social, além da prevenção de doenças e promoção de relacionamentos saudáveis.",
    newsTagMentalHealth: "#Saúde Mental",
    newsTitleMentalHealth: "Saúde mental recebe atenção crescente no Brasil",
    newsTextMentalHealth: "O cuidado com a saúde mental é cada vez mais valorizado, envolvendo estratégias de prevenção, tratamento de transtornos psicológicos e promoção do equilíbrio emocional para uma melhor qualidade de vida.",
    newsTagGlaucoma: "#Glaucoma",
    newsTitleGlaucoma: "Glaucoma: doença silenciosa que ameaça a visão",
    newsTextGlaucoma: "O glaucoma, caracterizado pelo aumento da pressão ocular, pode levar à perda da visão se não for diagnosticado precocemente. Profissionais recomendam consultas regulares para prevenção.",
    newsTagElders: "#idososBemEstar",
    newsTitleElders: "Bem‑Estar 360°: aliança entre idosos, cuidadores e tecnologia",
    newsTextElders: "Como monitorar glicemia, pressão, temperatura e batimentos cardíacos pode transformar qualidade de vida — e quais são os obstáculos que o novo aplicativo enfrenta nesse caminho.",
    newsBtn: "arrow_forward",
    ubsitaquera:"Localizada na Rua Américo Salvador Novelli, 265, oferece atendimento clínico, vacinação e exames de rotina.",
    ubscarmosina:"Situada na Rua Ipopoca, 61, oferece atendimento clínico, vacinação e exames de rotina. No centro da cidade, oferece atendimento clínico, vacinação e exames de rotina.",
    ubsaparecida:"Localizada na Rua Paulino Serqueira, 1, oferece atendimento clínico, vacinação e exames de rotina.",
    ubsbonifacio:"Situada na Rua Murmúrios da Tarde, oferece atendimento clínico, vacinação e exames de rotina.",
    ubsama:"Localizada na Rua Sílvio Barbini, 40, oferece atendimento clínico, vacinação e exames de rotina.",
    ubslider:"Localizada na Av. Dr. Francisco Munhoz Filho, 379, oferece atendimento clínico, vacinação e exames de rotina.",
    route_button: "Ver rota",

    //Footer
    footerHome: "Home",
    footerMonitoring: "Monitoramento",
    footerHistory: "Histórico",
    footerServices: "Serviços",
    footerFaq: "FAQ",
    footerContactTitle: "Contato",
    footerEmail: "Email: contato@bemestar360.com",
    footerPhone: "Telefone: (11) 1234-5678",
    footerCopy: "© 2025 Bem-Estar 360. Todos os direitos reservados.",

    //Página Pressão Arterial
      pressureTitle: "Registre a sua pressão arterial",
      systolicPressure: "Pressão Sistólica (mmHg)",
      diastolicPressure: "Pressão Diastólica (mmHg)",
      measurementDate: "Data da Medição",
      measurementTime: "Hora da Medição",
      observations: "Observações",
      saveRecord: "Salvar Registro",
      interpretationTitle: "Como interpretar seus registros de pressão",
      interpretationDesc: "Veja abaixo como entender os valores de pressão arterial registrados:",
      normal: "Normal",
      normalPressure: "Pressão sistólica até 120 mmHg\nPressão diastólica até 80 mmHg",
      attention: "Atenção",
      preHypertension: "Pressão sistólica entre 121-139 mmHg\nPressão diastólica entre 81-89 mmHg",
      danger: "Perigo",
      highPressure: "Pressão sistólica ≥ 140 mmHg\nPressão diastólica ≥ 90 mmHg",
        

    //Página Glicemia
   glucoseTitle: 'Registre a sua Glicemia',
   glucoseLabel: 'Glicemia (mg/dL)',
   saveButton: 'Salvar Registro',
   normal: 'Normal',
   altered: 'Alterado / Atenção',
   danger: 'Diabetes / Perigo',
   normalRange: 'Jejum: até <strong>99 mg/dL</strong><br>Pós-prandial: até <strong>140 mg/dL</strong>',
   alteredRange: 'Jejum: <strong>100-125 mg/dL</strong><br>Pós-prandial: <strong>141-199 mg/dL</strong>',
   dangerRange: 'Jejum: ≥ <strong>126 mg/dL</strong><br>Pós-prandial: ≥ <strong>200 mg/dL</strong>',
   normalMessage: '✅ Está dentro do esperado, continue monitorando regularmente.',
   alteredMessage: '⚠️ Fique atento! Pode indicar pré-diabetes ou necessidade de ajustes na alimentação e hábitos de vida.',
   dangerMessage: '⛔ Procure orientação médica imediatamente!',

    //Página Temperatura
    save: "Salvar Registro",
    temperature: "Temperatura (°C)",
    date: "Data da Medição",
    time: "Hora da Medição",
    observations: "Observações",
    help: "Como interpretar seus registros de temperatura",
    normal: "Normal",
    mild_fever: "Febre leve / Atenção",
    high_fever: "Febre alta / Perigo",

    //Página Batimentos cardíacos
    heartTitle: "Registre os seus Batimentos Cardíacos",
    timerLabel: "Conte seus batimentos por 60 segundos",
    timerHelp: "Não sabe contar seus batimentos manualmente?",
    startTimerBtn: "Iniciar Contagem",
    resetTimerBtn: "Reiniciar Contagem",
    bpmLabel: "Batimentos por Minuto (bpm)",
    bpmPlaceholder: "Ex: 72",
    dateLabel: "Data da Medição",
    timeLabel: "Hora da Medição",
    obsLabel: "Observações",
    obsPlaceholder: "Ex: medi após caminhada, senti cansaço...",
    saveBtn: "Salvar Registro",
    helpTitle: "Como interpretar seus registros de batimentos cardíacos",
    helpIntro: "Veja abaixo como entender os valores de frequência cardíaca registrados:",
    helpNormalTitle: "Normal",
    helpNormalRange: "Frequência cardíaca: 60-100 bpm",
    helpNormalText: "✅ Está dentro do esperado, continue monitorando regularmente.",
    helpAttentionTitle: "Atenção",
    helpAttentionRange: "Frequência cardíaca: 101-120 bpm",
    helpAttentionText: "⚠️ Fique atento! Pode indicar estresse, esforço físico recente ou necessidade de avaliação.",
    helpDangerTitle: "Perigo",
    helpDangerRange: "Frequência cardíaca: Menor que 50 bpm ou Maior que 120 bpm",
    helpDangerText: "⛔ Procure orientação médica imediatamente!",
    videoManual: "Manualmente",
    videoDigital: "Com aparelho digital de pulso",

    // Monitoramento
    monitorTitle: "Monitoramento em Tempo Real",
    cardBatimentos1: "❤️ Batimentos",
    cardGlicemia1: "🩸 Glicemia",
    cardTemperatura1: "🌡️ Temperatura",
    cardPressao1: "🩺 Pressão",
    historyTitle: "Histórico de Monitoramento",
    tableDate: "Data/Hora",
    tableBpm: "Batimentos (bpm)",
    tableGlicemia: "Glicemia (mg/dL)",
    tableTemperatura: "Temperatura (°C)",
    tablePressao: "Pressão (mmHg",
    exportPdf: "📄 Exportar PDF",

    //Serviços
    helpTitle: "Onde Procurar Ajuda?",
    ubsTitle: "🏥 UBS",
    ubsDescription: "Sintomas leves, consultas de rotina, vacinação, acompanhamento de doenças crônicas.",
    upaTitle: "🚑 UPA",
    upaDescription: "Emergências, febre alta persistente, dores intensas, acidentes, fraturas.",
    susTitle: "📱 SUS Digital",
    susDescription: "Agendamentos online, carteira de vacinação digital, histórico médico.",
    servicesTitle: "Serviços Oferecidos",
    ubsButton: "UBS – Unidade Básica de Saúde",
    consultations: "🩺 Consultas com clínico geral e especialistas",
    vaccination: "💉 Vacinação",
    routineExams: "🧪 Exames de rotina",
    chronicCare: "❤️‍🩹 Acompanhamento de hipertensão e diabetes",
    viewOnMap: "📍 Ver no Mapa",
    upaButton: "UPA – Unidade de Pronto Atendimento",
    emergencyCare: "⏱️ Atendimento emergencial 24h",
    patientStabilization: "🚑 Estabilização de pacientes",
    minorSurgery: "🩹 Pequenas cirurgias e suturas",
    quickExams: "🧾 Exames rápidos e internação curta",
    susDigitalButton: "SUS Digital",
    appointmentScheduling: "📅 Agendamento de consultas",
    digitalVaccinationCard: "📲 Carteira de vacinação digital",
    examTracking: "📑 Acompanhamento de exames e receitas",
    officialWebsite: "🌐 Acessar site oficial",
    feedbackQuestion: "Você conseguiu encontrar o serviço que procurava?",
    yesButton: "✅ Sim",
    noButton: "❌ Não",
    partialButton: "⚠️ Parcialmente",

    //Quem Somos
    whoWeAre: "Quem Somos",
    teamDescription: "Uma breve apresentação da nossa equipe — quatro pessoas, uma missão: construir produtos que importam.",
    availableForProjects: "Disponível para projetos: Web • Mobile • UI/UX",
    role1: "Desenvolvedor Web (Back-End)",
    specialty: "Especialidade em linguagem de programação:",
    role2: "Back-end & DevOps",
    specialty2: "Especialista em arquiteturas escaláveis e integrações. Ama resolver problemas complexos com simplicidade.",
    role3: "Desenvolvimento de Software em Java",
    specialty3: "Focado para carreira na área de:",
    role4: "Front-end Developer",
    specialty4: "Foca em interfaces acessíveis e performáticas. Ama design atencioso e testes end-to-end.",

    //Login
    loginDescription: "Faça login para acessar seu painel de saúde",
    emailLabel: "Email",
    passwordLabel: "Senha",
    loginButton:"Login",
    forgotPassword: "Esqueci minha senha",
    dontHaveAccount: "Não possui uma conta?",
    createAccount: "Crie a sua agora!",
    otherLoginMethods: "Faça login de outras maneiras",
    googleLogin: "Login com Google",
    govbrLogin: "Login com Gov.br",

     //Esqueceu a Senha
     recoverPasswordTitle: 'Recuperar Senha',
     recoverPasswordText: 'Informe seu e-mail para receber um código de confirmação para redefinir sua senha.',
     email: 'E-mail',
     submitButton: 'Enviar',
     backToLogin: 'Voltar ao login',
  },

  en: {
    home: "Home",
    monitoring: "Monitoring",
    history: "History",
    services: "Services",
    about: "About Us",
    login: "Login",
    settings: "⚙️",
    darkMode: "🌙 Dark Mode",
    lightMode: "☀️ Light Mode",
    accessibility: "♿ Accessibility",
    changeLang: "🌎 Change Language",

    //Home
    title: "Welcome to Bem-Estar 360!",
    text1: "Monitor your health daily and track your well-being in a simple, intuitive, and reliable way.",
    text2: "Our goal is to help you understand your body, adopt healthy habits, and prevent risks.",
    text3: "Record Your Health Data",
    text4: "To keep your monitoring up to date, click on the cards below and log your blood pressure, blood sugar, heart rate, and temperature readings. Daily logging helps you and healthcare professionals track your well-being more accurately.",
    cardPress: "Blood Pressure",
    cardPressP: "Record and track your blood pressure readings.",
    cardPressA: "Record your blood pressure",
    cardGlicemia: "Blood Sugar",
    cardGlicemiaP: "Record and track your blood sugar levels.",
    cardGlicemiaA: "Record Blood Sugar",
    cardBatimentos: "Heart Rate",
    cardBatimentosP: "Record and track your heart rate.",
    cardBatimentosA: "Record Heart Rate",
    cardTemperatura: "Temperature",
    cardTemperaturaP: "Record and track your body temperature.",
    cardTemperaturaA: "Record Temperature",
    newsTitle: "Last news about health",
    newsTagSUS: "#SUS",
    newsTitleSUS: "SUS ensures quality healthcare for all Brazilians",
    newsTextSUS: "The Unified Health System (SUS) continues to provide free healthcare, promoting prevention, treatment, and follow-up in various health areas, reinforcing its essential role in people's lives.",
    newsTagDiabetes: "#Diabetes",
    newsTitleDiabetes: "Diabetes requires ongoing care and monitoring",
    newsTextDiabetes: "Diabetes is a chronic condition that demands daily attention to diet, physical activity, and medical supervision. Early diagnosis is essential to avoid serious complications.",
    newsTagSexualHealth: "#SexualHealth",
    newsTitleSexualHealth: "Sexual health: the importance of prevention and well-being",
    newsTextSexualHealth: "Experts stress the importance of sexual health care, which includes physical, emotional, and social well-being, as well as disease prevention and the promotion of healthy relationships.",
    newsTagMentalHealth: "#MentalHealth",
    newsTitleMentalHealth: "Mental health receives growing attention in Brazil",
    newsTextMentalHealth: "Mental health care is increasingly valued, involving prevention strategies, treatment of psychological disorders, and promotion of emotional balance for a better quality of life.",
    newsTagGlaucoma: "#Glaucoma",
    newsTitleGlaucoma: "Glaucoma: a silent disease that threatens vision",
    newsTextGlaucoma: "Glaucoma, characterized by increased eye pressure, can lead to vision loss if not diagnosed early. Professionals recommend regular eye exams for prevention.",
    newsTagElders: "#elderBemEstar",
    newsTitleElders: "Bem‑Estar 360°: a partnership between seniors, caregivers, and technology",
    newsTextElders: "How monitoring blood sugar, blood pressure, temperature, and heart rate can transform quality of life — and what obstacles the new app faces along the way.",
    newsBtn: "arrow_forward",
    ubsitaquera:"Located at Rua Américo Salvador Novelli, 265, it offers clinical care, vaccination, and routine exams.",
    ubscarmosina:"Situated at Rua Ipopoca, 61, it offers clinical care, vaccination, and routine exams. In the city center, it offers clinical care, vaccination, and routine exams.",
    ubsaparecida:"Located at Rua Paulino Serqueira, 1, it offers clinical care, vaccination, and routine exams.",
    ubsbonifacio:"Situated at Rua Murmúrios da Tarde, it offers clinical care, vaccination, and routine exams.",
    ubsama:"Located at Rua Sílvio Barbini, 40, it offers clinical care, vaccination, and routine exams.",
    ubslider:"Located at Av. Dr. Francisco Munhoz Filho, 379, it offers clinical care, vaccination, and routine exams.",
    route_button: "View route",

    //Footer
    footerHome: "Home",
    footerMonitoring: "Monitoring",
    footerHistory: "History",
    footerServices: "Services",
    footerFaq: "FAQ",
    footerContactTitle: "Contact",
    footerEmail: "Email: contato@bemestar360.com",
    footerPhone: "Phone: +55 (11) 1234-5678",
    footerCopy: "© 2025 Wellness 360. All rights reserved.",

    //Página Pressão Arterial
       pressureTitle: "Register Your Blood Pressure",
      systolicPressure: "Systolic Pressure (mmHg)",
      diastolicPressure: "Diastolic Pressure (mmHg)",
      measurementDate: "Measurement Date",
      measurementTime: "Measurement Time",
      observations: "Observations",
      saveRecord: "Save Record",
      interpretationTitle: "How to Interpret Your Blood Pressure Records",
      interpretationDesc: "See below how to understand the registered blood pressure values:",
      normal: "Normal",
      normalPressure: "Systolic pressure up to 120 mmHg\nDiastolic pressure up to 80 mmHg",
      attention: "Attention",
      preHypertension: "Systolic pressure between 121-139 mmHg\nDiastolic pressure between 81-89 mmHg",
      danger: "Danger",
      highPressure: "Systolic pressure ≥ 140 mmHg\nDiastolic pressure ≥ 90 mmHg",
    
    //Página Glicemia
   glucoseTitle: 'Record Your Glucose',
   glucoseLabel: 'Glucose (mg/dL)',
   saveButton: 'Save Record',
   normal: 'Normal',
   altered: 'Altered / Attention',
   danger: 'Diabetes / Danger',
   normalRange: 'Fasting: up to <strong>99 mg/dL</strong><br>Post-prandial: up to <strong>140 mg/dL</strong>',
   alteredRange: 'Fasting: <strong>100-125 mg/dL</strong><br>Post-prandial: <strong>141-199 mg/dL</strong>',
   dangerRange: 'Fasting: ≥ <strong>126 mg/dL</strong><br>Post-prandial: ≥ <strong>200 mg/dL</strong>',
   normalMessage: '✅ Within expected range, keep monitoring regularly.',
   alteredMessage: '⚠️ Be careful! May indicate pre-diabetes or need for dietary and lifestyle adjustments.',                  'dangerMessage': '⛔ Seek medical advice immediately!',
   dangerMessage: '⛔ Seek medical advice immediately!',

   //Página Batimentos cardíacos
    heartTitle: "Record Your Heart Rate",
    timerLabel: "Count your beats for 60 seconds",
    timerHelp: "Don't know how to count your beats manually?",
    startTimerBtn: "Start Counting",
    resetTimerBtn: "Reset Counting",
    bpmLabel: "Beats Per Minute (bpm)",
    bpmPlaceholder: "Ex: 72",
    dateLabel: "Measurement Date",
    timeLabel: "Measurement Time",
    obsLabel: "Observations",
    obsPlaceholder: "Ex: measured after walking, felt tired...",
    saveBtn: "Save Record",
    helpTitle: "How to interpret your heart rate records",
    helpIntro: "See below how to understand the recorded heart rate values:",
    helpNormalTitle: "Normal",
    helpNormalRange: "Heart rate: 60-100 bpm",
    helpNormalText: "✅ Within the expected range, continue monitoring regularly.",
    helpAttentionTitle: "Attention",
    helpAttentionRange: "Heart rate: 101-120 bpm",
    helpAttentionText: "⚠️ Be alert! Could indicate stress, recent physical exertion, or need for evaluation.",
    helpDangerTitle: "Danger",
    helpDangerRange: "Heart rate: Less than 50 bpm or greater than 120 bpm",
    helpDangerText: "⛔ Seek medical advice immediately!",
    videoManual: "Manually",
    videoDigital: "With digital wrist device",

    //Página Temperatura
     save: "Save Record",
     temperature: "Temperature (°C)",
     date: "Measurement Date",
     time: "Measurement Time",
     observations: "Observations",
     help: "How to interpret your temperature records",
     normal: "Normal",
     mild_fever: "Mild Fever / Attention",
     high_fever: "High Fever / Danger",

     // Monitoramento
    monitorTitle: "Real-Time Monitoring",
    cardBatimentos1: "❤️ Heart Rate",
    cardGlicemia1: "🩸 Blood Sugar",
    cardTemperatura1: "🌡️ Temperature",
    cardPressao1: "🩺 Blood Pressure",
    historyTitle: "Monitoring History",
    tableDate: "Date/Time",
    tableBpm: "Heart Rate (bpm)",
    tableGlicemia: "Blood Sugar (mg/dL)",
    tableTemperatura: "Temperature (°C)",
    tablePressao: "Blood Pressure (mmHg",
    exportPdf: "📄 Export PDF",
    
    //Serviços
    helpTitle: "Where to Seek Help?",
    ubsTitle: "🏥 UBS",
    ubsDescription: "Mild symptoms, routine consultations, vaccination, chronic disease follow-up.",
    upaTitle: "🚑 UPA",
    upaDescription: "Emergencies, persistent high fever, intense pain, accidents, fractures.",
    susTitle: "📱 Digital SUS",
    susDescription: "Online appointments, digital vaccination card, medical history.",
    servicesTitle: "Offered Services",
    ubsButton: "UBS – Basic Health Unit",
    consultations: "🩺 General and specialist consultations",
    vaccination: "💉 Vaccination",
    routineExams: "🧪 Routine exams",
    chronicCare: "❤️‍🩹 Hypertension and diabetes follow-up",
    viewOnMap: "📍 View on Map",
    upaButton: "UPA – Emergency Care Unit",
    emergencyCare: "⏱️ 24h Emergency care",
    patientStabilization: "🚑 Patient stabilization",
    minorSurgery: "🩹 Minor surgeries and sutures",
    quickExams: "🧾 Quick exams and short-term hospitalization",
    susDigitalButton: "Digital SUS",
    appointmentScheduling: "📅 Appointment scheduling",
    digitalVaccinationCard: "📲 Digital vaccination card",
    examTracking: "📑 Exam and prescription tracking",
    officialWebsite: "🌐 Access official website",
    feedbackQuestion: "Did you find the service you were looking for?",
    yesButton: "✅ Yes",
    noButton: "❌ No",
    partialButton: "⚠️ Partially",

    //Quem Somos 
    whoWeAre: "Who We Are",
    teamDescription:"A brief introduction to our team — four people, one mission: to build products that matter.",
    availableForProjects:"Available for projects: Web • Mobile • UI/UX",
    role1: "Web Developer (Back-End)",
    specialty:"Specialty in programming languages:",
    role2:"Back-end & DevOps",
    specialty2:"Specialist in scalable architectures and integrations. Loves solving complex problems with simplicity.",
    role3: "Java Software Development",
    specialty3:"Focused on career in the area of:",
    role4: "Front-end Developer",
    specialty4:"Focuses on accessible and performant interfaces. Loves thoughtful design and end-to-end testing.",
   
    //Login
    loginDescription: "Log in to access your health dashboard",
    emailLabel: "Email",
    passwordLabel: "Password",
    loginButton: "Log in",
    forgotPassword: "Forgot password",
    dontHaveAccount: "Don't have an account?",
    createAccount: "Create one now!",
    otherLoginMethods: "Log in with other methods",
    googleLogin: "Log in with Google",
    govbrLogin: "Log in with Gov.br",

    //Esqueceu a senha
    recoverPasswordTitle: 'Recover Password',
    recoverPasswordText: 'Enter your email to receive a confirmation code to reset your password.',
    email: 'Email',
    submitButton: 'Send',
    backToLogin: 'Back to login',
  }
  
};

// Carregar preferência do idioma
let currentLang = localStorage.getItem("lang") || "pt";
applyLanguage(currentLang);

// Função para aplicar o idioma
function applyLanguage(lang) {
  document.querySelectorAll("[data-lang]").forEach(el => {
    const key = el.getAttribute("data-lang");
    el.textContent = translations[lang][key];
  });

  // Atualizar textos dos botões do dropdown
  toggleTheme.textContent = document.body.classList.contains("dark-mode")
    ? translations[lang].lightMode
    : translations[lang].darkMode;
  document.getElementById("accessibility").textContent = translations[lang].accessibility;
  langBtn.textContent = translations[lang].changeLang;

  localStorage.setItem("lang", lang);
}

// Alternar idioma ao clicar
langBtn.addEventListener("click", () => {
  currentLang = currentLang === "pt" ? "en" : "pt";
  applyLanguage(currentLang);
});






/* LOGIN */

const loginForm = document.getElementById("loginForm");
const errorMessage = document.getElementById("error-message");

loginForm.addEventListener("submit", function (e) {
  e.preventDefault();

  const email = document.getElementById("email").value.trim();
  const senha = document.getElementById("senha").value.trim();

  // Simulação de login
  if (email === "usuario@exemplo.com" && senha === "123456") {
    alert("Login bem-sucedido!");
    // Aqui você pode redirecionar para o dashboard
    window.location.href = "dashboard.html";
  } else {
    errorMessage.textContent = "Email ou senha incorretos!";
  }
});

















