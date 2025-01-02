var regole = {
    "DataNelPassato": function DataNelPassato(input, params = null){
        if (!input){
            return true;
        }
        var dataInserita = new Date(input);
        var oggi = new Date();
        oggi.setHours(0, 0, 0, 0);
        dataInserita.setHours(0,0,0,0);

        return dataInserita<=oggi;
    },

    "DataNelFuturo": function DataNelFuturo(input, params = null){
        if (!input){
            return true;
        }
        var dataInserita = new Date(input);
        var oggi = new Date();
        oggi.setHours(0, 0, 0, 0);
        dataInserita.setHours(0,0,0,0);

        return dataInserita>=oggi;
    },

    "InteroNonNegativo": function InteroNonNegativo(input, params = null){
        if(!input){
            return true;
        }
        return input>=0;
    },

    "MatchRegex": function MatchRegex(input, regex){
        return input.search(regex) == 0;
    },

    "RangeVisitatori": function RangeVisitatori(input, params = null){
        if(!input){
            return true;
        }
        return input<15 && input>0;
    }
}