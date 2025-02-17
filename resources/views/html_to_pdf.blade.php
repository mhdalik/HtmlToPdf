<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>HTML To PDF</title>
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-md">
        <h2 class="text-2xl font-semibold text-center text-red-700 mb-4">📄 PDF Generator</h2>

        <form action="/download-pdf" method="POST" target="_blank" class="space-y-4">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <!-- HTML Content -->
            <label class="block">
                <span class="text-red-700 font-medium">HTML Content:</span>
                <textarea name="html_content" id="html_content" rows="5" required class="mt-1 w-full p-2 border rounded-md focus:ring-2 focus:ring-red-400 focus:outline-none text-sm">
<h1>Sample PDF Content</h1>
<p>This is a demo PDF generated from HTML content.</p>
                </textarea>
            </label>

            <!-- Page Format & Orientation -->
            <div class="grid grid-cols-2 gap-4">
                <label class="block">
                    <span class="text-red-700 font-medium">Page Format:</span>
                    <select name="format" id="format" class="mt-1 w-full p-2 border rounded-md focus:ring-2 focus:ring-red-400 focus:outline-none text-sm">
                        <option value="A5" selected>A5</option>
                        <option value="A4">A4</option>
                        <option value="Letter">Letter</option>
                    </select>
                </label>

                <label class="block">
                    <span class="text-red-700 font-medium">Orientation:</span>
                    <select name="orientation" id="orientation"
                        class="mt-1 w-full p-2 border rounded-md focus:ring-2 focus:ring-red-400 focus:outline-none text-sm">
                        <option value="L" selected>Landscape</option>
                        <option value="P">Portrait</option>
                    </select>
                </label>
            </div>

            <!-- Margins -->
            <fieldset class="border rounded-md p-3 border-red-300">
                <legend class="text-red-700 font-medium px-2">Margins (mm)</legend>
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <label>Left:
                        <input type="number" name="margin_left" value="5" required class="w-full mt-1 p-1 border rounded-md focus:ring-2 focus:ring-red-400 focus:outline-none" />
                    </label>
                    <label>Right:
                        <input type="number" name="margin_right" value="5" required class="w-full mt-1 p-1 border rounded-md focus:ring-2 focus:ring-red-400 focus:outline-none" />
                    </label>
                    <label>Top:
                        <input type="number" name="margin_top" value="5" required class="w-full mt-1 p-1 border rounded-md focus:ring-2 focus:ring-red-400 focus:outline-none" />
                    </label>
                    <label>Bottom:
                        <input type="number" name="margin_bottom" value="5" required class="w-full mt-1 p-1 border rounded-md focus:ring-2 focus:ring-red-400 focus:outline-none" />
                    </label>
                </div>
            </fieldset>

            <button type="submit" class="w-full bg-red-500 text-white py-2 rounded-md hover:bg-red-600 transition duration-200">
                🚀 Generate PDF
            </button>
        </form>

        <p class="text-sm text-red-600 mt-4 text-center">For Arabic text, use
            <code class="bg-red-100 px-1 rounded">style="font-family:dejavusans"</code>
        </p>
    </div>
</body>

</html>