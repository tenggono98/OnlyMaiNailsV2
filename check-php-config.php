<?php
/**
 * PHP Configuration Checker for Image Upload
 * Run this script to check if your server meets the requirements
 */

echo "🔍 PHP Configuration Check for Image Upload\n";
echo "==========================================\n\n";

// Check PHP version
echo "PHP Version: " . PHP_VERSION . "\n";
if (version_compare(PHP_VERSION, '8.2.0', '>=')) {
    echo "✅ PHP version is compatible\n";
} else {
    echo "❌ PHP version is too old. Required: 8.2+\n";
}

// Check GD extension
echo "\nGD Extension:\n";
if (extension_loaded('gd')) {
    echo "✅ GD extension is loaded\n";
    $gdInfo = gd_info();
    echo "   - GD Version: " . $gdInfo['GD Version'] . "\n";
    echo "   - JPEG Support: " . ($gdInfo['JPEG Support'] ? 'Yes' : 'No') . "\n";
    echo "   - PNG Support: " . ($gdInfo['PNG Support'] ? 'Yes' : 'No') . "\n";
    echo "   - WebP Support: " . ($gdInfo['WebP Support'] ? 'Yes' : 'No') . "\n";
} else {
    echo "❌ GD extension is NOT loaded\n";
}

// Check file upload settings
echo "\nFile Upload Settings:\n";
echo "   - file_uploads: " . (ini_get('file_uploads') ? 'Enabled' : 'Disabled') . "\n";
echo "   - upload_max_filesize: " . ini_get('upload_max_filesize') . "\n";
echo "   - post_max_size: " . ini_get('post_max_size') . "\n";
echo "   - max_execution_time: " . ini_get('max_execution_time') . " seconds\n";
echo "   - memory_limit: " . ini_get('memory_limit') . "\n";
echo "   - max_input_vars: " . ini_get('max_input_vars') . "\n";

// Check temporary directory
echo "\nTemporary Directory:\n";
$tempDir = sys_get_temp_dir();
echo "   - temp_dir: " . $tempDir . "\n";
echo "   - writable: " . (is_writable($tempDir) ? 'Yes' : 'No') . "\n";

// Check storage directory
echo "\nStorage Directory:\n";
$storageDir = __DIR__ . '/storage/app/public';
echo "   - storage_dir: " . $storageDir . "\n";
echo "   - exists: " . (file_exists($storageDir) ? 'Yes' : 'No') . "\n";
echo "   - writable: " . (is_writable($storageDir) ? 'Yes' : 'No') . "\n";

// Recommendations
echo "\n📋 Recommendations:\n";
echo "==================\n";

if (!extension_loaded('gd')) {
    echo "❌ Install GD extension: sudo apt-get install php-gd\n";
}

if (ini_get('upload_max_filesize') !== '10M') {
    echo "⚠️  Consider increasing upload_max_filesize to 10M or higher\n";
}

if (ini_get('post_max_size') !== '10M') {
    echo "⚠️  Consider increasing post_max_size to 10M or higher\n";
}

if (ini_get('memory_limit') !== '256M') {
    echo "⚠️  Consider increasing memory_limit to 256M or higher\n";
}

if (ini_get('max_execution_time') < 60) {
    echo "⚠️  Consider increasing max_execution_time to 60 seconds or higher\n";
}

echo "\n✅ Configuration check complete!\n";
