import { context } from 'esbuild';
import { copy } from 'esbuild-plugin-copy';
import { mkdir } from 'node:fs/promises';
import { basename } from 'node:path';
import { glob } from 'tinyglobby';

const files = await glob('assets/*.{js,css}', {
    ignore: 'assets/*.min.{js,css}',
});

const other = await glob('assets/*', { ignore: ['assets/*.ts', ...files] });

await mkdir('public', { recursive: true });

const ctx = await context({
    entryPoints: files,
    outdir: 'public',
    outExtension: {
        '.js': '.min.js',
        '.css': '.min.css',
    },
    minify: true,
    allowOverwrite: true,
    plugins: [
        copy({
            resolveFrom: 'cwd',
            assets: other.map((o) => ({
                from: o,
                to: `public/${basename(o)}`,
            })),
            watch: true,
        }),
    ],
});
await ctx.watch();
