// assets\react/components\ui\Card.tsx

import React, { ReactNode } from 'react';

type CardProps = {
  children: ReactNode;
  className?: string;
};

export default function Card({ children, className = '' }: CardProps) {
  return (
    <div
      className={`rounded-2xl border-neutral-200 bg-color-card shadow-soft p-6 ${className}`}
    >
      {children}
    </div>
  );
}
