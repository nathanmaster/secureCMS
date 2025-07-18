<x-public-layout title="Debug Test">
    <div class="container mx-auto px-4 py-8">
        <div class="debug-test">
            <h1>DEBUG TEST PAGE</h1>
            <p>This is a simple test page to verify the layout is working.</p>
            <p>Current time: {{ date('Y-m-d H:i:s') }}</p>
            <p>Laravel version: {{ app()->version() }}</p>
        </div>
        
        <div class="bg-purple-800 text-white p-4 rounded-lg mt-4">
            <h2>Layout Test</h2>
            <p>If you can see this purple box, the styling is working.</p>
        </div>
        
        <div class="mt-4">
            <button id="testBtn" class="btn-purple">Click Me to Test JavaScript</button>
            <div id="testResult" class="mt-2 text-white"></div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.getElementById('testBtn').addEventListener('click', function() {
            console.log('Button clicked - JavaScript is working!');
            document.getElementById('testResult').innerHTML = 'JavaScript is working! Button clicked at ' + new Date().toLocaleTimeString();
        });
    </script>
    @endpush
</x-public-layout>
