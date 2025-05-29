import { copyFile, mkdir } from 'fs/promises';
import { dirname } from 'path';

async function build() {
    try {
        // Create public/js directory if it doesn't exist
        await mkdir('public/js', { recursive: true });
        
        // Copy app.js to public directory
        await copyFile('resources/js/app.js', 'public/js/app.js');
        
        console.log('Build completed successfully!');
    } catch (error) {
        console.error('Build failed:', error);
        process.exit(1);
    }
}

build(); 