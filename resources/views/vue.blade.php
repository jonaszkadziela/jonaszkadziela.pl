<x-main-layout>
    <script src="{{ asset('/build/messages.js') }}"></script>
    <script>
        Lang.setLocale('{{ App::getLocale() }}')
    </script>
    <div id="app"></div>
</x-main-layout>
