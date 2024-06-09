import moment from "moment";
import "moment/locale/pt-br";
moment.locale('pt-br');

export const formatHour = (time, format = "HH:mm") => {
    return moment(time, "HH:mm:ss").format(format);
};

export const formatDate = (dateString, format = "DD/MM/YYYY") => {
    return moment(dateString).format(format).toUpperCase();
};

export const formatDateTime = (dateString, format = "DD/MM/YYYY HH:mm") => {
    return moment(dateString).format(format).toUpperCase();
};

export function validateCpf(handleCPF) {
    let cpf = handleCPF.replace(/[^\d]+/g, "");

    if (cpf.length !== 11) {
        return false;
    }

    let sum;
    let remainder;
    sum = 0;
    if (
        cpf === "00000000000" ||
        cpf === "11111111111" ||
        cpf === "22222222222" ||
        cpf === "33333333333" ||
        cpf === "44444444444" ||
        cpf === "55555555555" ||
        cpf === "66666666666" ||
        cpf === "77777777777" ||
        cpf === "88888888888" ||
        cpf === "99999999999"
    ) {
        return false;
    }

    for (let i = 1; i <= 9; i++) {
        sum = sum + parseInt(cpf.substring(i - 1, i)) * (11 - i);
    }

    remainder = (sum * 10) % 11;

    if (remainder === 10 || remainder === 11) {
        remainder = 0;
    }

    if (remainder !== parseInt(cpf.substring(9, 10))) {
        return false;
    }

    sum = 0;
    for (let i = 1; i <= 10; i++) {
        sum = sum + parseInt(cpf.substring(i - 1, i)) * (12 - i);
    }

    remainder = (sum * 10) % 11;

    if (remainder === 10 || remainder === 11) {
        remainder = 0;
    }

    if (remainder !== parseInt(cpf.substring(10, 11))) {
        return false;
    }
}

export const fetchAddressData = async (zip_code) => {
    let cep = zip_code.split(".").join("").split("-").join("");

    return fetch(`https://viacep.com.br/ws/${cep}/json/`, {
        method: "GET",
        mode: "cors",
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
        },
    })
        .then((response) => response.json())
        .catch((error) => {
            console.error("Error response data:", error);
        });
};

export function formatCurrencyBRL(value) {
    const stringValue = String(value).replace(/\D/g, "");
    const numberValue = Number(stringValue) / 100;
    return numberValue.toLocaleString("pt-BR", {
        style: "currency",
        currency: "BRL",
    });
}
