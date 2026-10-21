import plugin from 'tailwindcss/plugin'
import tailwindCssMotion from 'tailwindcss-motion'

/*
 * Some presets of `tailwindcss-motion` (e.g. `motion-preset-confetti`) nest `@keyframes` inside their rules,
 * which is invalid CSS that Tailwind CSS v4 drops along with the rule's own declarations.
 * Move such `@keyframes` to the top level before passing the components to Tailwind CSS.
 */
export default plugin(api => {
    const extractKeyframes = (styles, keyframes) => Object.fromEntries(
        Object.entries(styles).filter(([key, value]) => {
            if (key.startsWith('@keyframes')) {
                keyframes[key] = value

                return false
            }

            return true
        }).map(([key, value]) => [
            key,
            value && typeof value === 'object' ? extractKeyframes(value, keyframes) : value,
        ]),
    )

    tailwindCssMotion.handler({
        ...api,
        addComponents: (components, options) => {
            const keyframes = {}

            api.addComponents(extractKeyframes(components, keyframes), options)
            api.addBase(keyframes)
        },
    })
}, tailwindCssMotion.config)
