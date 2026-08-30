import { inContainer } from 'in-container/async';
import { spawn } from 'node:child_process';

if (!(await inContainer())) {
    console.log(
        '\x1b[1;31m[ERROR]\x1b[0m You need to run this script from a container!',
    );
    console.log('\x1b[1;34m[INFO]\x1b[0m Run the "make" command instead!');
    process.exit(1);
}

spawn('node esbuild.config.js', { shell: true, stdio: 'inherit' });

spawn(
    'pnpm tailwindcss -i ./src/styles/global.css -o ./assets/global.min.css -m -w always --poll',
    { shell: true, stdio: 'inherit' },
);

console.log('\x1b[1;32m[SUCCESS]\x1b[0m Running...!');
