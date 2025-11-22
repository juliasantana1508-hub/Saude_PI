// tradução.js

const langBtn = document.getElementById("change-lang");

const translations = {
    // Títulos e cabeçalhos
    title: { pt: "Saúde 360 - Monitoramento", en: "Health 360 - Monitoring" },
    home: { pt: "Início", en: "Home" },
    monitoring: { pt: "Monitoramento", en: "Monitoring" },
    services: { pt: "Serviços", en: "Services" },
    about: { pt: "Sobre Nós", en: "About Us" },
    login: { pt: "Entrar", en: "Login" },
    darkMode: { pt: "🌙 Modo Escuro", en: "🌙 Dark Mode" },
    changeLang: { pt: "🌎 Alterar Idioma", en: "🌎 Change Language" },
    accessibility: { pt: "♿ Acessibilidade", en: "♿ Accessibility" },

    // Seção de Monitoramento
    monitorTitle: { pt: "Monitoramento em Tempo Real", en: "Real-Time Monitoring" },
    cardBatimentos: { pt: "❤️ Batimentos Cardíacos", en: "❤️ Heart Rate" },
    cardGlicemia: { pt: "🩸 Glicemia", en: "🩸 Blood Sugar" },
    cardTemperatura: { pt: "🌡️ Temperatura", en: "🌡️ Temperature" },
    cardPressao: { pt: "🩺 Pressão Arterial", en: "🩺 Blood Pressure" },
    historyTitle: { pt: "Histórico de Monitoramento", en: "Monitoring History" },
    tableDate: { pt: "Data/Hora", en: "Date/Time" },
    tableBpm: { pt: "Frequência Cardíaca (bpm)", en: "Heart Rate (bpm)" },
    tableGlicemia: { pt: "Glicemia (mg/dL)", en: "Blood Sugar (mg/dL)" },
    tableTemperatura: { pt: "Temperatura (°C)", en: "Temperature (°C)" },
    tablePressao: { pt: "Pressão Arterial (mmHg)", en: "Blood Pressure (mmHg)" },
    exportPdf: { pt: "📄 Exportar PDF", en: "📄 Export PDF" },

    // Batimentos Cardíacos
    heartTitle: { pt: "Registre seu Batimento Cardíaco", en: "Record Your Heart Rate" },
    timerLabel: { pt: "Conte seus batimentos por 60 segundos", en: "Count your heartbeats for 60 seconds" },
    timerHelp: { pt: "Não sabe como contar manualmente? <a href='#video-manual'>Clique aqui para assistir ao vídeo</a>", en: "Don't know how to count manually? <a href='#video-manual'>Click here to watch the video</a>" },
    startTimerBtn: { pt: "Começar a Contar", en: "Start Counting" },
    resetTimerBtn: { pt: "Reiniciar Contagem", en: "Reset Counting" },
    bpmLabel: { pt: "Batimentos por Minuto (bpm)", en: "Beats per Minute (bpm)" },
    bpmPlaceholder: { pt: "Ex: 72", en: "Ex: 72" },
    dateLabel: { pt: "Data da Medição", en: "Measurement Date" },
    timeLabel: { pt: "Hora da Medição", en: "Measurement Time" },
    obsLabel: { pt: "Observações", en: "Observations" },
    obsPlaceholder: { pt: "Ex: medido após caminhar, senti cansaço...", en: "Ex: measured after walking, felt tired..." },
    saveBtn: { pt: "Salvar Registro", en: "Save Record" },
    // Ajuda / Interpretação dos Batimentos
    helpTitle: { pt: "Como interpretar seus registros de batimentos cardíacos", en: "How to interpret your heart rate records" },
    helpIntro: { pt: "Veja abaixo como entender os valores registrados de batimentos cardíacos:", en: "See below how to understand the registered heart rate values:" },
    helpNormalTitle: { pt: "Normal", en: "Normal" },
    helpNormalRange: { pt: "Frequência cardíaca: <strong>60-100 bpm</strong>", en: "Heart rate: <strong>60-100 bpm</strong>" },
    helpNormalText: { pt: "✅ Dentro da faixa esperada, continue monitorando regularmente.", en: "✅ Within expected range, keep monitoring regularly." },
    helpAttentionTitle: { pt: "Atenção", en: "Attention" },
    helpAttentionRange: { pt: "Frequência cardíaca: <strong>101-120 bpm</strong>", en: "Heart rate: <strong>101-120 bpm</strong>" },
    helpAttentionText: { pt: "⚠️ Tenha cautela! Pode indicar estresse, esforço físico recente ou necessidade de avaliação.", en: "⚠️ Be cautious! May indicate stress, recent physical effort, or need for evaluation." },
    helpDangerTitle: { pt: "Perigo", en: "Danger" },
    helpDangerRange: { pt: "Frequência cardíaca: <strong>Menos que 50 bpm ou mais que 120 bpm</strong>", en: "Heart rate: <strong>Less than 50 bpm or More than 120 bpm</strong>" },
    helpDangerText: { pt: "⛔ Procure orientação médica imediatamente!", en: "⛔ Seek medical advice immediately!" },
    videoManual: { pt: "Manualmente", en: "Manually" },
    videoDigital: { pt: "Com dispositivo digital de pulso", en: "With digital wrist device" },

    // Rodapé
    footerBrand: { pt: "Saúde 360", en: "Health 360" },
    footerHome: { pt: "Início", en: "Home" },
    footerMonitoring: { pt: "Monitoramento", en: "Monitoring" },
    footerHistory: { pt: "Serviços", en: "Services" },
    footerServices: { pt: "Sobre Nós", en: "About Us" },
    footerFaq: { pt: "Perguntas Frequentes", en: "FAQ" },
    footerContactTitle: { pt: "Contato", en: "Contact" },
    footerEmail: { pt: "Email: contact@health360.com", en: "Email: contact@health360.com" },
    footerPhone: { pt: "Telefone: (11) 1234-5678", en: "Phone: (11) 1234-5678" },
    footerCopy: { pt: "© 2025 Saúde 360. Todos os direitos reservados.", en: "© 2025 Health 360. All rights reserved." }
};


// Função que aplica as traduções
function applyTranslations(lang = "en") {
    document.querySelectorAll("[data-lang]").forEach(el => {
        const key = el.getAttribute("data-lang");
        if (translations[key]) {
            el.innerHTML = translations[key];
        }
    });

    document.querySelectorAll("[data-lang-placeholder]").forEach(el => {
        const key = el.getAttribute("data-lang-placeholder");
        if (translations[key]) {
            el.setAttribute("placeholder", translations[key]);
        }
    });

    const title = document.querySelector("title[data-lang]");
    if (title && translations[title.getAttribute("data-lang")]) {
        title.textContent = translations[title.getAttribute("data-lang")];
    }
}

// Ativar tradução automaticamente ao carregar a página
document.addEventListener("DOMContentLoaded", () => {
    applyTranslations("en");
});

// Alternar idioma ao clicar no botão
if (langBtn) {
    langBtn.addEventListener("click", () => {
        applyTranslations("en"); // pode ser ajustado para alternar pt/en
    });
}
