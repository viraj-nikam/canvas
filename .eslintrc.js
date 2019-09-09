module.exports = {
    root: true,
    env: {
        es6: true,
        node: true,
        browser: true
    },
    parserOptions: {
        ecmaVersion: 2018,
        sourceType: "module"
    },
    extends: [
        "plugin:vue/essential",
        "plugin:prettier/recommended",
        "eslint:recommended"
    ],
    rules: {
        "vue/max-attributes-per-line": [2, {
                "singleline": 20,
                "multiline": {
                    "max": 1,
                    "allowFirstLine": false
                }
            }
        ]
    }
}
