<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Perimeter Fence Estimation Prototype</title>
</head>
<body style="font-family: sans-serif; margin: 40px;">

    <h2>Perimeter Fence Estimation Prototype</h2>
    
    <form action="/calculate" method="POST">
        @csrf
        
        <h3>1. Geometric Parameters</h3>
        <p>
            <label>Total Wall Length (meters):</label><br>
            <input type="number" step="0.01" name="length" placeholder="e.g., 30" required style="padding: 5px; width: 250px;">
        </p>

        <p>
            <label>Wall Height (meters):</label><br>
            <input type="number" step="0.01" name="height" placeholder="e.g., 2.2" required style="padding: 5px; width: 250px;">
        </p>

        <p>
            <label>CHB Thickness:</label><br>
            <select name="thickness" style="padding: 5px; width: 264px;">
                <option value="0.10">0.10m (4 inches)</option>
                <option value="0.15" selected>0.15m (6 inches)</option>
            </select>
        </p>

        <h3 style="margin-top: 30px;">2. Labor & Schedule</h3>
        <p>
            <label>
                <input type="checkbox" id="enableCustomLabor" name="enable_custom" value="1" onchange="toggleCustomLabor()"> 
                <strong>Enable Manual Labor & Schedule Overrides</strong>
            </label>
        </p>

        <!-- Hidden by default -->
        <div id="customLaborFields" style="display: none; background: #f9f9f9; padding: 15px; border: 1px solid #ddd; width: 300px;">
            <p>
                <label>Target Work Duration (days):</label><br>
                <input type="number" name="custom_days" placeholder="e.g., 10" style="padding: 5px; width: 250px;">
            </p>

            <p>
                <label>Number of Skilled Masons:</label><br>
                <input type="number" name="custom_masons" value="2" min="1" style="padding: 5px; width: 250px;">
            </p>

            <p>
                <label>Number of General Laborers:</label><br>
                <input type="number" name="custom_laborers" value="2" min="1" style="padding: 5px; width: 250px;">
            </p>
        </div>

        <p style="margin-top: 20px;">
            <button type="submit" style="padding: 10px 20px; font-weight: bold;">Generate Estimate</button>
        </p>
    </form>

    <script>
        function toggleCustomLabor() {
            const checkbox = document.getElementById('enableCustomLabor');
            const fieldsDiv = document.getElementById('customLaborFields');
            fieldsDiv.style.display = checkbox.checked ? 'block' : 'none';
        }
    </script>

</body>
</html>