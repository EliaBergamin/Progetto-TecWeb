var regole = {
    "DataNelPassato": function DataNelPassato(input, params = null) {
        if (!input) {
            return true;
        }
        let dataInserita = new Date(input);
        let oggi = new Date();
        oggi.setHours(0, 0, 0, 0);
        dataInserita.setHours(0, 0, 0, 0);

        return dataInserita <= oggi;
    },

    "DataNelFuturo": function DataNelFuturo(input, params = null) {
        if (!input) {
            return true;
        }
        let dataInserita = new Date(input);
        let oggi = new Date();
        oggi.setHours(0, 0, 0, 0);
        dataInserita.setHours(0, 0, 0, 0);

        return dataInserita >= oggi;
    },

    "OrarioNelFuturo": function OrarioNelFuturo(input, params = null) {
        let dateInput = document.getElementById("giorno").value;
        if (!input || !dateInput) {
            return true;
        }
        let dataInserita = new Date(document.getElementById("giorno").value);
        let oggi = new Date();
        return dataInserita.setHours(0, 0, 0, 0) > oggi.setHours(0, 0, 0, 0) || new Date(input) > oggi;
    },

    "InteroNonNegativo": function InteroNonNegativo(input, params = null) {
        if (!input) {
            return true;
        }
        return input >= 0;
    },

    "MatchRegex": function MatchRegex(input, regex) {
        return input.search(regex) == 0;
    },

    "RangeVisitatori": function RangeVisitatori(input, params = null) {
        if (!input) {
            return true;
        }
        return parseInt(input) <= parseInt(params) && parseInt(input) > 0;
    },

    "DataFine": function DataFine(input, params = null) {
        const dataInserita = document.getElementById("data_inizio").value;
        if (!input || !dataInserita) {
            return true;
        }
        const dataInizio = new Date(dataInserita);
        const dataFine = new Date(input);
        return dataFine >= dataInizio;
    }
}