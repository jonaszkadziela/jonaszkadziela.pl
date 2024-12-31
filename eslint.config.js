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
            globals: {
                ...globals.browser,
                Lang: false,
            },
        },
        rules: {
            'vue/multi-word-component-names': ['error', {
                'ignores': ['Footer'],
            }],
            'vue/html-indent': ['error', 4, {
                'alignAttributesVertically': true,
                'attribute': 1,
                'baseIndent': 1,
                'closeBracket': 0,
                'ignores': [],
            }],
        },
    },
]
