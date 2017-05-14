<?php

class Base
{
    static public $_FILTER_DASHBOARD_TYPES_ = [
        'h' => 'Hoje',
        'u1' => 'Última hora',
        'u6' => 'Últimas 6 horas',
        'u12' => 'Últimas 12 horas',
        'u24' => 'Últimas 24 horas',

        'ha' => 'Hora atual',

        'da' => 'Dia atual',
        'u7d' => 'Últimos 7 dias',
        'u15d' => 'Últimos 15 dias',
        'm' => 'Desde início do mês',

        'ma' => 'Mês atual',
        'u3m' => 'Últimos 3 meses',
        'aa' => 'Desde início do ano',
    ];

    static public $_ALERT_TYPES_ = [
        '0' => 'Falha de Sensor',
        '1' => 'Falha de Energia',
        '2' => 'Sensor Inativo',
        '3' => 'Valor de Indicador'
    ];
    static public $_ALERT_CONDITIONS_ = [
        '0' => 'Dentro da faixa',
        '1' => 'Fora da faixa',
        '2' => 'Igual a',
        '3' => 'Diferente de',
        '4' => 'Maior que',
        '5' => 'Maior ou igual a',
        '6' => 'Menor que',
        '7' => 'Menor ou igual a'
    ];
    static public $_INDICADORES_ = [
        'laeq' => ['nome' => 'Ruído Médio Total', 'escala' => 'dB', 'faixa' => ['min' => 30, 'max' => 130], 'tipo' => 'float'],
        'lceq' => ['nome' => 'Nível de Pressão Sonora Médio', 'escala' => 'dB', 'faixa' => ['min' => 30, 'max' => 130], 'tipo' => 'float'],
        'lamax' => ['nome' => 'Nível de Pressão Sonora Pico', 'escala' => 'dB', 'faixa' => ['min' => 30, 'max' => 130], 'tipo' => 'float'],
        'lamin' => ['nome' => 'LAmin', 'escala' => 'dB', 'faixa' => ['min' => 30, 'max' => 130], 'tipo' => 'float'],
        'la90' => ['nome' => 'Ruído de Fundo', 'escala' => 'dB', 'faixa' => ['min' => 30, 'max' => 130], 'tipo' => 'float'],
        'la50' => ['nome' => 'Ruído de Equipamentos', 'escala' => 'dB', 'faixa' => ['min' => 30, 'max' => 130], 'tipo' => 'float'],
        'la10' => ['nome' => 'Ruído de Conversação', 'escala' => 'dB', 'faixa' => ['min' => 30, 'max' => 130], 'tipo' => 'float'],
        'alarm_set' => ['nome' => 'Alame Set', 'escala' => 'dB', 'faixa' => ['min' => 30, 'max' => 130], 'tipo' => 'float'],
        'ipa' => ['nome' => 'IPA', 'escala' => 's', 'faixa' => ['min' => 0, 'max' => 100], 'tipo' => 'int'],
        'time_leq' => ['nome' => 'Tempo de Leq', 'escala' => 'seg', 'faixa' => ['min' => 0, 'max' => 30], 'tipo' => 'int'],
        'temp' => ['nome' => 'Temperatura', 'escala' => 'ºC', 'faixa' => ['min' => 0, 'max' => 50], 'tipo' => 'float'],
        'ilum' => ['nome' => 'Iluminação', 'escala' => 'LUX', 'faixa' => ['min' => 0, 'max' => 65000], 'tipo' => 'int'],
        'umid' => ['nome' => 'Umidade', 'escala' => '%', 'faixa' => ['min' => 0, 'max' => 100], 'tipo' => 'int'],
        'temp_i' => ['nome' => 'Temperatura Interna', 'escala' => 'ºC', 'faixa' => ['min' => -55, 'max' => 125], 'tipo' => 'float'],
        'ipaporcento' => ['nome' => 'Percentual Acima do Limite', 'escala' => '%', 'faixa' => ['min' => 0, 'max' => 100], 'tipo' => 'float'],

        'power' => ['nome' => 'Potência Elétrica', 'escala' => 'W/h', 'faixa' => ['min' => 0, 'max' => 25000], 'tipo' => 'int'],
        'expense' => ['nome' => 'Consumo de Energia Elétrica (hora)', 'escala' => 'kWh', 'faixa' => ['min' => 0, 'max' => 25000], 'tipo' => 'int'],
        'expensed' => ['nome' => 'Consumo de Energia Elétrica (diário)', 'escala' => 'kWh', 'faixa' => ['min' => 0, 'max' => 25000], 'tipo' => 'int'],
        'expensem' => ['nome' => 'Consumo de Energia Elétrica (mês)', 'escala' => 'kWh', 'faixa' => ['min' => 0, 'max' => 25000], 'tipo' => 'int'],
        'water' => ['nome' => 'Consumo de Água', 'escala' => 'L/min', 'faixa' => ['min' => 0, 'max' => 30], 'tipo' => 'float']
    ];
    static public $_RANGE_MINIMAX_ = [
        'ipa' => [
            'min' => 0,
            'max' => 100,
        ],
        'time_leq' => [
            'min' => 0,
            'max' => 30,
        ],
        'temp' => [
            'min' => 0,
            'max' => 50,
        ],
        'umid' => [
            'min' => 0,
            'max' => 100,
        ],
        'ilum' => [
            'min' => 0,
            'max' => 65000,
        ],
        'temp_i' => [
            'min' => -55,
            'max' => 125,
        ],

        //NOVOS INDICADORES
        'ipaporcento' => [
            'min' => 0,
            'max' => 100,
        ],

        //NOVOS INDICADORES
        'power' => [
            'min' => 0,
            'max' => 25000,
        ],
        'expense' => [
            'min' => 0,
            'max' => 25000,
        ],
        'expensed' => [
            'min' => 0,
            'max' => 25000,
        ],
        'expensem' => [
            'min' => 0,
            'max' => 25000,
        ],
        'water' => [
            'min' => 0,
            'max' => 30,
        ],

        'default' => [
            'min' => 30,
            'max' => 130,
        ]
    ];

    static public $_GRUPOINDICADORES_ = [
        [
            'indicadores' => ['laeq'],
            'indice' => 'laeq',
            'impressao' => 'Ruído Médio Total',
            'filtros_dashboard' => ['h', 'u1', 'u6', 'u12', 'u24'],
            'colors' => ["#FF6600"],
            'bullets' => ["round"],
        ],
        [
            'indicadores' => ['lceq'],
            'indice' => 'lceq',
            'impressao' => 'Nível de Pressão Sonora Médio',
            'filtros_dashboard' => ['h', 'u1', 'u6', 'u12', 'u24'],
            'colors' => ["#FCD202"],
            'bullets' => ["square"],
        ],
        [
            'indicadores' => ['lamax'],
            'indice' => 'lamax',
            'impressao' => 'Nível de Pressão Sonora Pico',
            'filtros_dashboard' => ['h', 'u1', 'u6', 'u12', 'u24'],
            'colors' => ["#1f77b4"],
            'bullets' => ["triangleUp"],
        ],
        [
            'indicadores' => ['lamin'],
            'indice' => 'lamin',
            'impressao' => 'LAmin',
            'filtros_dashboard' => ['h', 'u1', 'u6', 'u12', 'u24'],
            'colors' => ["#aec7e8"],
            'bullets' => ["triangleDown"],
        ],
        [
            'indicadores' => ['la90'],
            'indice' => 'la90',
            'impressao' => 'Ruído de Fundo',
            'filtros_dashboard' => ['h', 'u1', 'u6', 'u12', 'u24'],
            'colors' => ["#98df8a"],
            'bullets' => ["bubble"],
        ],
        [
            'indicadores' => ['la50'],
            'indice' => 'la50',
            'impressao' => 'Ruído de Equipamentos',
            'filtros_dashboard' => ['h', 'u1', 'u6', 'u12', 'u24'],
            'colors' => ["#d62728"],
            'bullets' => ["round"],
        ],
        [
            'indicadores' => ['la10'],
            'indice' => 'la10',
            'impressao' => 'Ruído de Conversação',
            'filtros_dashboard' => ['h', 'u1', 'u6', 'u12', 'u24'],
            'colors' => ["#9467bd"],
            'bullets' => ["square"],
        ],
        [
            'indicadores' => ['time_leq'],
            'indice' => 'time_leq',
            'impressao' => 'Tempo de Leq',
            'filtros_dashboard' => ['h', 'u1', 'u6', 'u12', 'u24'],
            'colors' => ["#8c564b"],
            'bullets' => ["triangleUp"],
        ],
        [
            'indicadores' => ['alarm_set'],
            'indice' => 'alarm_set',
            'impressao' => 'Alame Set',
            'filtros_dashboard' => ['h', 'u1', 'u6', 'u12', 'u24'],
            'colors' => ["#ff7f0e"],
            'bullets' => ["triangleDown"],
        ],
        [
            'indicadores' => ['ipa'],
            'indice' => 'ipa',
            'impressao' => 'IPA',
            'filtros_dashboard' => ['h', 'u1', 'u6', 'u12', 'u24'],
            'colors' => ["#ffbb78"],
            'bullets' => ["bubble"],
        ],
        [
            'indicadores' => ['temp'],
            'indice' => 'temp',
            'impressao' => 'Temperatura',
            'filtros_dashboard' => ['h', 'u1', 'u6', 'u12', 'u24'],
            'colors' => ["#c49c94"],
            'bullets' => ["round"],
        ],
        [
            'indicadores' => ['ipaporcento'],
            'indice' => 'ipaporcento',
            'impressao' => 'Percentual Acima do Limite',
            'filtros_dashboard' => ['h', 'u1', 'u6', 'u12', 'u24'],
            'colors' => ["#c49c94"],
            'bullets' => ["round"],
        ],
        [
            'indicadores' => ['ilum'],
            'indice' => 'ilum',
            'impressao' => 'Iluminação',
            'filtros_dashboard' => ['h', 'u1', 'u6', 'u12', 'u24'],
            'colors' => ["#e377c2"],
            'bullets' => ["square"],
        ],
        [
            'indicadores' => ['umid'],
            'indice' => 'umid',
            'impressao' => 'Umidade',
            'filtros_dashboard' => ['h', 'u1', 'u6', 'u12', 'u24'],
            'colors' => ["#f7b6d2"],
            'bullets' => ["triangleUp"],
        ],
        [
            'indicadores' => ['temp_i'],
            'indice' => 'temp_i',
            'impressao' => 'Temperatura Interna',
            'filtros_dashboard' => ['h', 'u1', 'u6', 'u12', 'u24'],
            'colors' => ["#7f7f7f"],
            'bullets' => ["triangleDown"],
        ],
        [
            'indicadores' => ['power'],
            'indice' => 'power',
            'impressao' => 'Potência Elétrica',
            'filtros_dashboard' => ['h', 'u1', 'u6', 'u12', 'u24'],
            'colors' => ["#c7c7c7"],
            'bullets' => ["bubble"],
        ],
        [
            'indicadores' => ['expense'],
            'indice' => 'expense',
            'impressao' => 'Consumo de Energia Elétrica (hora)',
            'filtros_dashboard' => ['h', 'ha', 'u6', 'u12', 'u24'],
            'colors' => ["#bcbd22"],
            'bullets' => ["round"],
        ],
        [
            'indicadores' => ['expensed'],
            'indice' => 'expensed',
            'impressao' => 'Consumo de Energia Elétrica (diário)',
            'filtros_dashboard' => ['da', 'u7d', 'u15d', 'm'],
            'colors' => ["#dbdb8d"],
            'bullets' => ["square"],
        ],
        [
            'indicadores' => ['expensem'],
            'indice' => 'expensem',
            'impressao' => 'Consumo de Energia Elétrica (mês)',
            'filtros_dashboard' => ['ma', 'u3m', 'aa'],
            'colors' => ["#17becf"],
            'bullets' => ["triangleUp"],
        ],
        [
            'indicadores' => ['water'],
            'indice' => 'water',
            'impressao' => 'Consumo de Água',
            'filtros_dashboard' => ['h', 'u1', 'u6', 'u12', 'u24'],
            'colors' => ["#9edae5"],
            'bullets' => ["triangleDown"],
        ],

        //GRUPOS
        [
            'indicadores' => ['laeq', 'lceq'],
            'indice' => 'laeq,lceq',
            'impressao' => 'Ruído Médio Total x Nível de Pressão Sonora Médio',
            'filtros_dashboard' => ['h', 'u1', 'u6', 'u12', 'u24'],
            'colors' => ["#FF6600", "#FCD202"],
            'bullets' => ["round", "#square"],
        ],
        [
            'indicadores' => ['lamax', 'lamin'],
            'indice' => 'lamax,lamin',
            'impressao' => 'Nível de Pressão Sonora Pico x LAmin',
            'filtros_dashboard' => ['h', 'u1', 'u6', 'u12', 'u24'],
            'colors' => ["#1f77b4", "#aec7e8"],
            'bullets' => ["triangleUp", "triangleDown"],
        ],
        [
            'indicadores' => ['la90', 'la50', 'la10'],
            'indice' => 'la90,la50,la10',
            'impressao' => 'Ruído de Fundo x Ruído de Equipamentos x Ruído de Conversação',
            'filtros_dashboard' => ['h', 'u1', 'u6', 'u12', 'u24'],
            'colors' => ["#98df8a", "#d62728", "#9467bd"],
            'bullets' => ["bubble", "round", "square"],
        ],
        [
            'indicadores' => ['time_leq', 'alarm_set', 'ipa'],
            'indice' => 'time_leq,alarm_set,ipa',
            'impressao' => 'Tempo de Leq x Alame Set x IPA',
            'filtros_dashboard' => ['h', 'u1', 'u6', 'u12', 'u24'],
            'colors' => ["#8c564b", "#ff7f0e", "#ffbb78"],
            'bullets' => ["triangleUp", "triangleDown", "bubble"],
        ],
        [
            'indicadores' => ['temp', 'ilum', 'umid', 'temp_i'],
            'indice' => 'temp,ilum,umid,temp_i',
            'impressao' => 'Temperatura x Iluminação x Umidade x Temperatura Interna',
            'filtros_dashboard' => ['h', 'u1', 'u6', 'u12', 'u24'],
            'colors' => ["#c49c94", "#e377c2", "#f7b6d2", "#7f7f7f"],
            'bullets' => ["round", "square", "triangleUp", "triangleDown"],
        ],
        [
            'indicadores' => ['lceq', 'alarm_set', 'ipa'],
            'indice' => 'lceq,alarm_set,ipa',
            'impressao' => 'Nível de Pressão Sonora Médio x Alame Set x IPA',
            'filtros_dashboard' => ['h', 'u1', 'u6', 'u12', 'u24'],
            'colors' => ["#FCD202", "#ff7f0e", "#ffbb78"],
            'bullets' => ["square", "triangleDown", "bubble"],
        ],
        [
            'indicadores' => ['lceq', 'alarm_set', 'ipa', 'ipaporcento'],
            'indice' => 'lceq,alarm_set,ipa,ipaporcento',
            'impressao' => 'Nível de Pressão Sonora Médio x Alame Set x IPA x Percentual Acima do Limite',
            'filtros_dashboard' => ['h', 'u1', 'u6', 'u12', 'u24'],
            'colors' => ["#FCD202", "#ff7f0e", "#ffbb78", "#7f7f7f"],
            'bullets' => ["square", "triangleDown", "bubble", "triangleUp"],
        ],
//        Nível de Pressão Sonora Médio; Alame Set; IPA; Percentual Acima do Limite - See more at: http://medisom.com.br/admin/relatorio-customizado#sthash.JDDDurkM.dpuf
        [
            'indicadores' => ['lamax', 'alarm_set', 'ipa'],
            'indice' => 'lamax,alarm_set,ipa',
            'impressao' => 'Nível de Pressão Sonora Pico x Alame Set x IPA',
            'filtros_dashboard' => ['h', 'u1', 'u6', 'u12', 'u24'],
            'colors' => ["#1f77b4", "#ff7f0e", "#ffbb78"],
            'bullets' => ["triangleUp", "triangleDown", "bubble"],
        ],
    ];
    static public $_NOT_MLOG_ = ["time_leq", "alarm_set", "ipa", "temp", "ilum", "umid", "temp_i", "ipaporcento", "power", "expense", "expensed", "expensem", "water"]; // que não são vai ser calculada a média logarítmica, ou seja, média aritmética
    static public $_NOT_RANGE_ = ["time_leq", "ipa", "temp", "ilum", "ipaporcento", "power", "expense", "expensed", "expensem", "water"]; // que não são default da variável $_RANGE_MINIMAX_
    static public $_DIAS_DA_SEMANA_ = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado');
    static public $_DAYS_OF_WEEK_ = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

    static public function getDiasByKeysStr($keys)
    {
        $cont = COUNT($keys);
        if ($cont > 1) {
            foreach ($keys as $key) {
                $retorno[] = self::$_DIAS_DA_SEMANA_[$key];
            }
            return ' Dias: ' . implode('; ', $retorno) . '.';
        } else if ($cont == 1) {
            return ' Dia: ' . self::$_DIAS_DA_SEMANA_[$keys[0]] . '.';
        } else {
            return NULL;
        }
    }
}
