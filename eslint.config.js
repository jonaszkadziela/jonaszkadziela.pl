import globals from 'globals'
import pluginJs from '@eslint/js'
import pluginVue from 'eslint-plugin-vue'

/** @type {import('eslint').Linter.Config[]} */
export default [
    pluginJs.configs.recommended,
    ...pluginVue.configs['flat/essential'],
    {
        files: ['**/*.{js,vue}'],
        languageOptions: {
            globals: globals.browser,
        },
        rules: {
            'vue/multi-word-component-names': ['error', { 'ignores': ['Footer'] }],
        },
    },
]
