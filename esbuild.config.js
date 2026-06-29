import { context } from 'esbuild';
import { copyFile, mkdir, watch } from 'node:fs/promises';
import { basename } from 'node:path';
import { glob } from 'tinyglobby';

const files = await glob('assets/*.{js,css}', {
    ignore: 'assets/*.min.{js,css}',
});

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
});
await ctx.watch();

const watcher = watch('assets/', { recursive: true });
for await (const _ of watcher) {
    const other = await glob('assets/*', { ignore: ['assets/*.ts', ...files] });
    await Promise.all(
        other.map(async (o) => await copyFile(o, `public/${basename(o)}`)),
    );
}
