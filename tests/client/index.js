import jca_test from "./jca_test.js";
import queries from "./queries.js";

const root='./../../tests/server';

const tests=[
    ['basic',root+'/api.php', queries],
];
jca_test(tests[0][1],tests[0][2]);
