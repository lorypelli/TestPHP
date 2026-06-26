import isDocker from 'is-docker';
import { exec } from 'node:child_process';
import { access } from 'node:fs/promises';
import { setTimeout } from 'node:timers/promises';

if (!isDocker()) {
    console.log(
        '\x1b[1;31m[ERROR]\x1b[0m You need to run this script from docker!',
    );
    console.log('\x1b[1;34m[INFO]\x1b[0m Run the "make" command instead!');
    process.exit(1);
}

exec(
    'pnpm tailwindcss -i ./src/styles/global.css -o ./assets/global.min.css -m -w always',
);

while (true) {
    try {
        await access('assets/global.min.css');
        break;
    } catch {
        await setTimeout(500);
    }
}

exec('node esbuild.config.js');

console.log('\x1b[1;32m[SUCCESS]\x1b[0m Running...!');
